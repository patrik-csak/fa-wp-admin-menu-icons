<?php

namespace Fawpami;

require_once 'AdminNotices.php';
require_once 'Hooks.php';

final class Fawpami
{
    public static function addHooks()
    {
        add_action('admin_notices', [AdminNotices::class, 'html']);
        add_filter(
            'register_post_type_args',
            [Hooks::class, 'filterRegisterPostTypeArgs']
        );
        add_filter('set_url_scheme', [Hooks::class, 'filterSetUrlScheme']);
    }

    /**
     * Test whether a string is a valid Font Awesome class.
     *
     * For Font Awesome v5, the class should look like this:
     * `[fas|far|fab] fa-<icon>`, for example: `fas fa-camera-retro`. See
     * {@link https://fontawesome.com/how-to-use/svg-with-js#styles-and-prefixes
     * Font Awesome 5 Styles & Prefixes}.
     *
     * For Font Awesome v4, the class should look like this:
     * `fa fa-<icon>`, for example: `fa fa-camera-retro`. See {@link
     * http://fontawesome.io/examples/#basic Font Awesome 4 Basic Icons}.
     *
     * @param string $string
     *
     * @return bool
     */
    public static function isFaClass($string)
    {
        return !!preg_match('/^fa[bsr]\s+fa-[\w-]+$/', $string);
    }

    /**
     * Test whether string uses FA WP Admin Menu Icons v4 syntax, which was
     * simply `'fa-<icon>'` (without the `'fa '` prefix)
     *
     * @param $string
     *
     * @return bool
     */
    public static function isFaClassV4($string)
    {
        return strpos($string, 'fa-') === 0;
    }

    public static function pluginName()
    {
        return \get_plugin_data(
            __DIR__ . '/../fa-wp-admin-menu-icons.php'
        )['Name'];
    }

    /**
     * @return array
     */
    public static function shims()
    {
        $shims = json_decode(file_get_contents(__DIR__ . '/fa-shims.json'));

        foreach ($shims as &$shim) {
            $shim['v4Name'] = $shim[0];
            $shim['v5Name'] = $shim[2];
            $shim['v5Prefix'] = $shim[1] ?: 'fas';
            for ($i = 0; $i < 3; $i++) {
                unset($shim[$i]);
            }
        }

        return $shims;
    }

    /**
     * Get the Font Awesome v5 class from the Font Awesome v4 class/icon
     *
     * @param $faV4Class
     *
     * @return string|false
     */
    public static function faV5Class($faV4Class)
    {
        if (self::isFaClass($faV4Class)) {
            return $faV4Class;
        }
        if (self::isFaClassV4($faV4Class)) {
            $iconName = self::stripFaPrefix($faV4Class);
            $v5IconName = self::faV5IconName($iconName);
            $prefix = self::faV5IconPrefix($iconName);

            return "{$prefix} fa-{$v5IconName}";
        }

        return false;
    }

    /**
     * Get the Font Awesome v5 name from the Font Awesome v4 name
     *
     * @param string $faV4IconName The Font Awesome v4 icon name
     *
     * @return string The Font Awesome v5 icon name, if found, else the original
     *                name.
     */
    public static function faV5IconName($faV4IconName)
    {
        $shims = self::shims();
        foreach ($shims as $shim) {
            if ($shim['v4Name'] === $faV4IconName) {
                return $shim['v5Name'];
            }
        }

        return $faV4IconName;
    }

    /**
     * Get the Font Awesome v5 prefix from the Font Awesome v4 name
     *
     * @param string $faV4IconName The Font Awesome v4 icon name
     *
     * @return string The Font Awesome v5 icon prefix, if found, else `'fas'`.
     */
    public static function faV5IconPrefix($faV4IconName)
    {
        $shims = self::shims();
        foreach ($shims as $shim) {
            if ($shim['v4Name'] === $faV4IconName) {
                return $shim['v5Prefix'];
            }
        }

        return 'fas';
    }

    public static function stripFaPrefix($string)
    {
        return strpos($string, 'fa-') === 0 ? substr($string, 3) : $string;
    }
}
