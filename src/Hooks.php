<?php

namespace Fawpami;

require_once 'Exception.php';
require_once 'Fawpami.php';
require_once 'Icon.php';

final class Hooks
{
    /**
     * Replace Font Awesome class string with icon SVG data URI
     *
     * @param array $args
     *
     * @return array
     */
    public static function filterRegisterPostTypeArgs($args)
    {
        $setErrorIcon = function () use (&$args) {
            $errorIcon = new Icon('fas fa-exclamation-triangle');
            try {
                $args['menu_icon'] = $errorIcon->svgDataUri();
            } catch (Exception $exception) {
            }
        };

        if (isset($args['menu_icon'])) {
            $menuIcon = $args['menu_icon'];

            if (Fawpami::isFaClass($menuIcon)) {
                try {
                    $icon = new Icon($menuIcon);
                    $args['menu_icon'] = $icon->svgDataUri();
                } catch (Exception $exception) {
                    AdminNotices::add($exception->getMessage(), 'error');
                    $setErrorIcon();
                }
            } elseif (Fawpami::isFaClassV4($menuIcon)) {
                $faV5IconClass = Fawpami::faV5Class($menuIcon);

                try {
                    $faV5Icon = new Icon($faV5IconClass);
                    $args['menu_icon'] = $faV5Icon->svgDataUri();

                    AdminNotices::add(
                        "FA WP Admin Menu Icons now uses Font Awesome 5! Please replace <code>{$menuIcon}</code> with <code>{$faV5IconClass}</code>.",
                        'warning'
                    );
                } catch (Exception $exception) {
                    AdminNotices::add(
                        "FA WP Admin Menu Icons now uses Font Awesome 5! Please use the new <a href='https://fontawesome.com/how-to-use/svg-with-js#styles-and-prefixes' target='_blank'>Font Awesome v5 class syntax</a>.",
                        'error'
                    );
                    $setErrorIcon();
                }
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
    public static function filterSetUrlScheme($url)
    {
        $setErrorIcon = function () use (&$url) {
            $errorIcon = new Icon('fas fa-exclamation-triangle');
            try {
                $url = $errorIcon->svgDataUri();
            } catch (Exception $exception) {
            }
        };

        if (Fawpami::isFaClass($url)) {
            $iconName = $url;

            try {
                $icon = new Icon($iconName);
                return $icon->svgDataUri();
            } catch (Exception $exception) {
                AdminNotices::add($exception->getMessage(), 'error');
                $setErrorIcon();
            }
        } elseif (Fawpami::isFaClassV4($url)) {
            $iconName = $url;
            $faV5IconClass = Fawpami::faV5Class($iconName);

            try {
                $faV5Icon = new Icon($faV5IconClass);
                $url = $faV5Icon->svgDataUri();

                AdminNotices::add(
                    "FA WP Admin Menu Icons now uses Font Awesome 5! Please replace <code>{$iconName}</code> with <code>{$faV5IconClass}</code>.",
                    'warning'
                );
            } catch (Exception $exception) {
                AdminNotices::add(
                    "FA WP Admin Menu Icons now uses Font Awesome 5! Please use the new <a href='https://fontawesome.com/how-to-use/svg-with-js#styles-and-prefixes' target='_blank'>Font Awesome v5 class syntax</a>.",
                    'error'
                );
                $setErrorIcon();
            }
        }

        return $url;
    }
}
