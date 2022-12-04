<?php

namespace Fawpami;

require_once 'AdminNotices.php';
require_once 'Icon.php';
require_once 'Scripts.php';

class Hooks
{
    private Fawpami $fawpami;

    public function __construct(Fawpami $fawpami)
    {
        $this->fawpami = $fawpami;
    }

    /**
     * Replace Font Awesome class string with icon SVG data URI
     *
     * @param array $args
     * @param string $name
     *
     * @return array
     */
    public function filterRegisterPostTypeArgs(array $args, string $name): array
    {
        if (!isset($args['menu_icon'])) {
            return $args;
        }

        $menuIcon = $args['menu_icon'];
        $isFaClass = $this->fawpami->isFaClass($menuIcon);
        $isFaClassV4 = $this->fawpami->isFaClassV4($menuIcon);

        if (!($isFaClass || $isFaClassV4)) {
            return $args;
        }

        Scripts::registerPostType($name);

        if ($isFaClassV4) {
            $this->fawpami->addV4SyntaxWarning($menuIcon);
            $menuIcon = $this->fawpami->faV5Class($menuIcon);
        }
        try {
            $icon = new Icon([
                'faClass' => $menuIcon,
                'fawpami' => $this->fawpami,
            ]);
            $args['menu_icon'] = $icon->svgDataUri();
        } catch (Exception $exception) {
            AdminNotices::add($exception->getMessage(), 'error');

            try {
                $icon = new Icon([
                    'faClass' => 'fas fa-exclamation-triangle',
                    'fawpami' => $this->fawpami,
                    'faVersion' => '5.15.4',
                ]);
                $args['menu_icon'] = $icon->svgDataUri();
            } catch (Exception $e) {
                // This shouldn't happen because we know the exclamation
                // triangle icon is valid
            }
        }

        return $args;
    }

    /**
     * Replace Font Awesome class string with icon SVG data URI
     *
     * @param string $url
     *
     * @return string
     */
    public function filterSetUrlScheme(string $url): string
    {
        $isFaClass = $this->fawpami->isFaClass($url);
        $isFaClassV4 = $this->fawpami->isFaClassV4($url);

        if (!($isFaClass || $isFaClassV4)) {
            return $url;
        }

        global $admin_page_hooks;
        $pages = $admin_page_hooks;
        $menuIcon = $url;

        // The most recently registered menu page should be this one
        end($pages);
        Scripts::registerMenuPage(key($pages));

        if ($isFaClassV4) {
            $this->fawpami->addV4SyntaxWarning($menuIcon);
            $menuIcon = $this->fawpami->faV5Class($menuIcon);
        }

        try {
            $icon = new Icon([
                'faClass' => $menuIcon,
                'fawpami' => $this->fawpami,
            ]);

            return $icon->svgDataUri();
        } catch (Exception $exception) {
            AdminNotices::add($exception->getMessage(), 'error');

            try {
                $icon = new Icon([
                    'faClass' => 'fas fa-exclamation-triangle',
                    'fawpami' => $this->fawpami,
                    'faVersion' => '5.15.4',
                ]);

                return $icon->svgDataUri();
            } catch (Exception $e) {
                // This shouldn't happen because we know the exclamation
                // triangle icon is valid
            }
        }

        return $url;
    }
}
