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
            $iconName = $args['menu_icon'];
            if (Fawpami::isFaClass($iconName)) {
                $icon = new Icon($iconName);
                try {
                    $args['menu_icon'] = $icon->svgDataUri();
                } catch (Exception $exception) {
                    Fawpami::adminNotice($exception->getMessage(), 'error');
                    $setErrorIcon();
                }
            } elseif (Fawpami::isFaClassDeprecated($iconName)) {
                $faV5IconName   = Fawpami::faV5IconName(Fawpami::stripFaPrefix($iconName));
                $faV5IconPrefix = Fawpami::faV5IconPrefix(Fawpami::stripFaPrefix($iconName));
                $faV5IconClass  = "{$faV5IconPrefix} fa-{$faV5IconName}";
                $faV5Icon       = new Icon($faV5IconClass);
                try {
                    $args['menu_icon'] = $faV5Icon->svgDataUri();
                    Fawpami::adminNotice(
                      "FA WP Admin Menu Icons now uses Font Awesome 5! Please replace <code>{$iconName}</code> with <code>{$faV5IconClass}</code>.",
                      'warning'
                    );
                } catch (Exception $exception) {
                    Fawpami::adminNotice(
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
            $icon     = new Icon($iconName);
            try {
                return $icon->svgDataUri();
            } catch (Exception $exception) {
                Fawpami::adminNotice($exception->getMessage(), 'error');
                $setErrorIcon();
            }
        } elseif (Fawpami::isFaClassDeprecated($url)) {
            $iconName       = $url;
            $faV5IconName   = Fawpami::faV5IconName(Fawpami::stripFaPrefix($iconName));
            $faV5IconPrefix = Fawpami::faV5IconPrefix(Fawpami::stripFaPrefix($iconName));
            $faV5IconClass  = "{$faV5IconPrefix} fa-{$faV5IconName}";
            $faV5Icon       = new Icon($faV5IconClass);
            try {
                $url = $faV5Icon->svgDataUri();
                Fawpami::adminNotice(
                  "FA WP Admin Menu Icons now uses Font Awesome 5! Please replace <code>{$iconName}</code> with <code>{$faV5IconClass}</code>.",
                  'warning'
                );
            } catch (Exception $exception) {
                Fawpami::adminNotice(
                  "FA WP Admin Menu Icons now uses Font Awesome 5! Please use the new <a href='https://fontawesome.com/how-to-use/svg-with-js#styles-and-prefixes' target='_blank'>Font Awesome v5 class syntax</a>.",
                  'error'
                );
                $setErrorIcon();
            }
        }

        return $url;
    }
}
