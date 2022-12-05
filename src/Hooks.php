<?php

namespace Fawpami;

require_once 'AdminNotices.php';
require_once 'Icon.php';
require_once 'Scripts.php';

class Hooks
{
    /**
     * Replace Font Awesome class string with icon SVG data URI
     */
    public function filterRegisterPostTypeArgs(array $args, string $name): array
    {
        $menuIcon = $args['menu_icon'] ?? null;

        if (!$menuIcon || !Fawpami::isFaClass($menuIcon)) {
            return $args;
        }

        Scripts::registerPostType($name);

        try {
            $icon = new Icon(['faClass' => $menuIcon]);
            $args['menu_icon'] = $icon->svgDataUri();
        } catch (Exception $exception) {
            AdminNotices::add($exception->getMessage(), 'error');

            try {
                $icon = new Icon(['faClass' => 'fas fa-exclamation-triangle']);
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
     */
    public function filterSetUrlScheme(string $url): string
    {
        if (!Fawpami::isFaClass($url)) {
            return $url;
        }

        global $admin_page_hooks;
        $pages = $admin_page_hooks;
        $menuIcon = $url;

        // The most recently registered menu page should be this one
        end($pages);
        Scripts::registerMenuPage(key($pages));

        try {
            $icon = new Icon(['faClass' => $menuIcon]);

            return $icon->svgDataUri();
        } catch (Exception $exception) {
            AdminNotices::add($exception->getMessage(), 'error');

            try {
                $icon = new Icon(['faClass' => 'fas fa-exclamation-triangle']);

                return $icon->svgDataUri();
            } catch (Exception $e) {
                // This shouldn't happen because we know the exclamation
                // triangle icon is valid
            }
        }

        return $url;
    }
}
