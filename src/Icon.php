<?php

namespace Fawpami;

require_once 'Exception.php';

class Icon
{
    /** @var string */
    private $iconUrl;

    /** @var string */
    private $optionName;

    /**
     * @param string $faClass Font Awesome class, i.e. `'fas fa-camera-retro'`
     * @param Fawpami $fawpami
     *
     * @throws Exception
     */
    public function __construct($faClass, $fawpami)
    {
        if (!$fawpami->isFaClass($faClass)) {
            throw new Exception(
                "'{$faClass}' is not a valid Font Awesome class. See Fawpami\Fawpami::isFaClass() for more information."
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
        $this->iconUrl = "https://raw.githubusercontent.com/FortAwesome/Font-Awesome/5.0.8/advanced-options/raw-svg/{$style}/{$icon}.svg";
        $this->optionName = 'fawpami_icon_'
            . str_replace('-', '_', $icon)
            . "_{$style}";
    }

    /**
     * @return string
     * @throws Exception
     */
    public function svgDataUri()
    {
        if ($cached = \get_option($this->optionName)) {
            return $cached;
        }

        $response = \wp_remote_get($this->iconUrl);

        if (\is_wp_error($response)) {
            throw new Exception($response->get_error_message());
        }

        if (($code = \wp_remote_retrieve_response_code($response)) !== 200) {
            throw new Exception(
                "HTTP request to <code>{$this->iconUrl}</code> failed with code <code>{$code}</code>"
            );
        }

        $svg = new \SimpleXMLElement($response['body']);

        /*
         * Add black fill, as recommended by WordPres:
         * https://codex.wordpress.org/Function_Reference/register_post_type#menu_icon
         */
        $svg->addAttribute('style', 'fill:black');
        $svgDataUri = 'data:image/svg+xml;base64,'
            . base64_encode($svg->asXML());
        \add_option($this->optionName, $svgDataUri);

        return $svgDataUri;
    }
}
