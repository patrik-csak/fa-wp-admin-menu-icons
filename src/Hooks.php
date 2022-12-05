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
    public static function filterRegisterPostTypeArgs(array $args, string $name): array
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
            $icon = new Icon(['faClass' => 'fas fa-exclamation-triangle']);
            $args['menu_icon'] = $icon->svgDataUri();
        }

        return $args;
    }

    /**
     * Replace Font Awesome class string with icon SVG data URI
     */
    public static function filterSetUrlScheme(string $url): string
    {
        if (!Fawpami::isFaClass($url)) {
            return $url;
        }

        // The most recently registered menu page should be this one
        global $admin_page_hooks;
        Scripts::registerMenuPage(array_key_last($admin_page_hooks));

        try {
            $icon = new Icon(['faClass' => $url]);
            return $icon->svgDataUri();
        } catch (Exception $exception) {
            AdminNotices::add($exception->getMessage(), 'error');
            $icon = new Icon(['faClass' => 'fas fa-exclamation-triangle']);
            return $icon->svgDataUri();
        }
    }
}
