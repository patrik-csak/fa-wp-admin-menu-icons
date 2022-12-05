<?php

namespace Fawpami;

use Exception;

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
        if (
            !isset($args['menu_icon']) ||
            !$icon = Icon::fromClass($args['menu_icon'])
        ) {
            return $args;
        }

        Scripts::registerPostType($name);

        try {
            $args['menu_icon'] = $icon->getSvgDataUri();
        } catch (Exception $exception) {
            AdminNotices::add($exception->getMessage(), 'error');

            try {
                $args['menu_icon'] = Icon
                    ::fromClass('fa-solid fa-triangle-exclamation')
                    ->getSvgDataUri();
            } catch (Exception $exception) {
                AdminNotices::add($exception->getMessage(), 'error');
            }
        }

        return $args;
    }

    /**
     * Replace Font Awesome class string with icon SVG data URI
     */
    public static function filterSetUrlScheme(string $url): string
    {
        if (!$icon = Icon::fromClass($url)) {
            return $url;
        }

        // The most recently registered menu page should be this one
        global $admin_page_hooks;
        Scripts::registerMenuPage(array_key_last($admin_page_hooks));

        try {
            return $icon->getSvgDataUri();
        } catch (Exception $exception) {
            AdminNotices::add($exception->getMessage(), 'error');

            try {
                return Icon::fromClass('fa-solid fa-triangle-exclamation')
                    ->getSvgDataUri();
            } catch (Exception $exception) {
                AdminNotices::add($exception->getMessage(), 'error');

                return $url;
            }
        }
    }
}
