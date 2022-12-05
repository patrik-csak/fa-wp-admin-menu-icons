<?php

namespace Fawpami;

use SimpleXMLElement;

use function add_option;
use function get_option;
use function is_wp_error;
use function wp_remote_get;
use function wp_remote_retrieve_response_code;

require_once 'Exception.php';

class Icon
{
    private string $icon;

    private string $style;

    /**
     * @throws Exception
     */
    public function __construct(string $class)
    {
        if (!Fawpami::isFaClass($class)) {
            throw new Exception(
                "'{$class}' is not a valid Font Awesome class"
            );
        }

        preg_match(
            '/^fa(?<style>[bsr])\s+fa-(?<icon>[\w-]+)$/',
            $class,
            $matches
        );

        $icon = $matches['icon'];

        $style = match ($matches['style']) {
            'b' => 'brands',
            's' => 'solid',
            'r' => 'regular',
            default => null
        };

        if (!$style) {
            throw new Exception("Failed to parse class '$class'");
        }

        $this->icon = $icon;
        $this->style = $style;
    }

    private function getSvgDataUriFromCache(): string|false
    {
        return get_option($this->getOptionName());
    }

    private function getOptionName(): string
    {
        return "fawpami_icon_{$this->icon}_{$this->style}_" . Fawpami::FA_VERSION;
    }

    /**
     * @throws Exception
     */
    private function getSvgFromGitHub(): string
    {
        $url = 'https://raw.githubusercontent.com/FortAwesome/Font-Awesome/' .
            Fawpami::FA_VERSION .
            "/svgs/$this->style/$this->icon.svg";
        $response = wp_remote_get($url);
        $body = wp_remote_retrieve_body($response);

        if (!$body || wp_remote_retrieve_response_code($response) !== 200) {
            $message = is_wp_error($response)
                ? $response->get_error_message()
                : "Failed to download icon from $url";

            throw new Exception($message);
        }

        return $body;
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    private function getSvgDataUriFromGitHub(): string
    {
        $svg = new SimpleXMLElement($this->getSvgFromGitHub());

        // Add black fill, as recommended by WordPress:
        // https://codex.wordpress.org/Function_Reference/register_post_type#menu_icon
        $svg->addAttribute('style', 'fill:black');

        return 'data:image/svg+xml;base64,' . base64_encode($svg->asXML());
    }

    private function cacheSvgDataUri(string $svgDataUri): void
    {
        add_option($this->getOptionName(), $svgDataUri);
    }

    /**
     * @throws Exception
     */
    public function getSvgDataUri(): string
    {
        if ($cached = $this->getSvgDataUriFromCache()) {
            return $cached;
        }

        $svgDataUri = $this->getSvgDataUriFromGitHub();

        $this->cacheSvgDataUri($svgDataUri);

        return $svgDataUri;
    }
}
