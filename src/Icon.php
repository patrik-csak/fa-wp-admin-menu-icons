<?php

namespace Fawpami;

require_once 'Exception.php';
require_once 'Fawpami.php';

final class Icon
{
    /** @var string */
    private $icon;

    /** @var string */
    private $iconPath;

    /**
     * @param string $faClass Font Awesome class, i.e. `'fas fa-camera-retro'`
     *
     * @throws Exception
     */
    public function __construct($faClass)
    {
        if ( ! Fawpami::isFaClass($faClass)) {
            throw new Exception("'${faClass}' is not a valid Font Awesome class. See Fawpami\Fawpami::isFaClass for more information.");
        }

        preg_match('/^fa([bsr])\s+fa-([\w-]+)$/', $faClass, $matches);

        $this->icon = $matches[2];
        if ($matches[1] === 'b') {
            $style = 'brands';
        } elseif ($matches[1] === 's') {
            $style = 'solid';
        } elseif ($matches[1] === 'r') {
            $style = 'regular';
        }
        $this->iconPath = __DIR__ . "/../icons/{$style}/{$this->icon}.svg";
    }

    /**
     * @return string
     * @throws Exception
     */
    public function svgDataUri()
    {
        $iconPath = $this->iconPath;
        $iconFile = @file_get_contents($iconPath);

        if ( ! $iconFile) {
            throw new Exception("The icon <code>'{$this->icon}'</code> could not be found at <code>${iconPath}</code>.");
        }

        /*
         * Add black fill, as recommended by WordPres:
         * https://codex.wordpress.org/Function_Reference/register_post_type#menu_icon
         */
        $svg = new \SimpleXMLElement($iconFile);
        $svg->addAttribute('style', 'fill:black');

        return 'data:image/svg+xml;base64,' . base64_encode($svg->asXML());
    }
}
