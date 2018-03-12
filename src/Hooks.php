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
        if (isset($args['menu_icon'])) {
            $menuIcon = $args['menu_icon'];
            $isFaClass = Fawpami::isFaClass($menuIcon);
            $isFaClassV4 = Fawpami::isFaClassV4($menuIcon);

            if ($isFaClass || $isFaClassV4) {
                if ($isFaClassV4) {
                    Fawpami::addV4SyntaxWarning($menuIcon);
                    $menuIcon = Fawpami::faV5Class($menuIcon);
                }
                try {
                    $args['menu_icon'] = (new Icon($menuIcon))->svgDataUri();
                } catch (Exception $exception) {
                    AdminNotices::add($exception->getMessage(), 'error');
                    $args['menu_icon'] =
                        (new Icon('fas fa-exclamation-triangle'))->svgDataUri();
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
        $isFaClass = Fawpami::isFaClass($url);
        $isFaClassV4 = Fawpami::isFaClassV4($url);

        if ($isFaClass || $isFaClassV4) {
            $menuIcon = $url;
            if ($isFaClassV4) {
                Fawpami::addV4SyntaxWarning($menuIcon);
                $menuIcon = Fawpami::faV5Class($menuIcon);
            }

            try {
                return (new Icon($menuIcon))->svgDataUri();
            } catch (Exception $exception) {
                AdminNotices::add($exception->getMessage(), 'error');
                return (new Icon('fas fa-exclamation-triangle'))->svgDataUri();
            }
        }

        return $url;
    }
}
