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
    /** @var string */
    private $iconUrl;

    /** @var string */
    private $optionName;

    /**
     * $params['faClass']   string  Font Awesome class, i.e.
     *                              `'fas fa-camera-retro'`
     * $params['fawpami']   Fawpami
     * $params['faVersion'] string  Font Awesome version. Optional. If not set,
     *                              `$params['fawpami']->version` will be used.
     *
     * @param array $params
     *
     * @throws Exception
     */
    public function __construct(array $params)
    {
        $faClass = $params['faClass'] ?? null;
        $fawpami = $params['fawpami'] ?? null;
        $faVersion = $params['faVersion'] ?? null;
        $faGithubUrl = 'https://raw.githubusercontent.com/FortAwesome/Font-Awesome';

        foreach (['faClass', 'fawpami'] as $param) {
            if (!$$param) {
                throw new Exception(
                    __METHOD__ . ' called with missing parameter ' .
                    "`\$params['{$param}']`"
                );
            }
        }

        if (!$fawpami->isFaClass($faClass)) {
            throw new Exception(
                "'{$faClass}' is not a valid Font Awesome class"
            );
        }

        preg_match(
            '/^fa(?<style>[bsr])\s+fa-(?<icon>[\w-]+)$/',
            $faClass,
            $matches
        );

        $icon = $matches['icon'];

        if ($matches['style'] === 'b') {
            $style = 'brands';
        } elseif ($matches['style'] === 's') {
            $style = 'solid';
        } elseif ($matches['style'] === 'r') {
            $style = 'regular';
        }

        $faVersion = $faVersion ?: $fawpami->faVersion;

        if (Version::lessThan($faVersion, '5.6.0')) {
            $this->iconUrl = "{$faGithubUrl}/{$faVersion}/advanced-options/" .
                             "raw-svg/{$style}/{$icon}.svg";
        } else {
            $this->iconUrl = "{$faGithubUrl}/{$faVersion}/svgs/{$style}" .
                             "/{$icon}.svg";
        }

        $this->optionName = 'fawpami_icon_' . str_replace('-', '_', $icon) .
                            "_{$style}_{$faVersion}";
    }

    /**
     * @return string
     * @throws Exception
     */
    public function svgDataUri(): string
    {
        if ($cached = get_option($this->optionName)) {
            return $cached;
        }

        $response = wp_remote_get($this->iconUrl);

        if (is_wp_error($response)) {
            throw new Exception($response->get_error_message());
        }

        if (($code = wp_remote_retrieve_response_code($response)) !== 200) {
            throw new Exception(
                "HTTP request to <code>{$this->iconUrl}</code> failed with " .
                "code <code>{$code}</code>"
            );
        }

        $svg = new SimpleXMLElement($response['body']);

        /*
         * Add black fill, as recommended by WordPres:
         * https://codex.wordpress.org/Function_Reference/register_post_type#menu_icon
         */
        $svg->addAttribute('style', 'fill:black');
        $svgDataUri = 'data:image/svg+xml;base64,'
                      . base64_encode($svg->asXML());
        add_option($this->optionName, $svgDataUri);

        return $svgDataUri;
    }
}
