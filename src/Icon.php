<?php

namespace Fawpami;

use Exception;
use JsonException;
use SimpleXMLElement;

require_once 'Fawpami.php';

class Icon
{
    private const FONT_AWESOME_CLASS_PATTERN = '/^fa-?(?<style>b|brands|r|regular|s|solid)\s+fa-(?<name>[a-z-]+)$/';

    public function __construct(
        private string $name,
        private string $style,
    ) {
    }

    public static function fromClass(string $class): self|null
    {
        $result = preg_match(
            self::FONT_AWESOME_CLASS_PATTERN,
            $class,
            $matches,
        );

        if ($result !== 1) {
            return null;
        }

        $style = match ($matches['style']) {
            'b', 'brands' => 'brands',
            'r', 'regular' => 'regular',
            's', 'solid' => 'solid',
        };

        return new self($matches['name'], $style);
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

    private function getSvgDataUriFromCache(): string|false
    {
        return get_option($this->getOptionName());
    }

    private function getOptionName(): string
    {
        return "fawpami_icon_{$this->name}_{$this->style}_" . Fawpami::FONT_AWESOME_VERSION;
    }

    /**
     * @throws Exception
     */
    private function getSvgDataUriFromGitHub(): string
    {
        $svg = new SimpleXMLElement($this->getSvgFromGitHub());

        // Add black fill, as recommended by WordPress:
        // https://codex.wordpress.org/Function_Reference/register_post_type#menu_icon
        $svg->addAttribute('style', 'fill:black');

        return 'data:image/svg+xml;base64,' . base64_encode($svg->asXML());
    }

    /**
     * @throws Exception
     */
    private function getSvgFromGitHub(): string
    {
        $name = $this->getUnaliasedName();
        $url = 'https://raw.githubusercontent.com/FortAwesome/Font-Awesome/' .
            Fawpami::FONT_AWESOME_VERSION .
            "/free/svgs/$this->style/$name.svg";
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

    private function cacheSvgDataUri(string $svgDataUri): void
    {
        add_option($this->getOptionName(), $svgDataUri);
    }

    /**
     * @throws JsonException
     */
    private function getUnaliasedName(): string
    {
        $aliases = json_decode(
            file_get_contents(__DIR__. '/aliases.json'),
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        );

        return $aliases[$this->name] ?? $this->name;
    }
}
