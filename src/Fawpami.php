<?php

namespace Fawpami;

use function get_plugin_data;

require_once 'AdminNotices.php';
require_once 'Hooks.php';
require_once 'Styles.php';
require_once 'Version.php';

class Fawpami
{
    /** @var string */
    public const FA_VERSION = '5.13.0';

    /** @var AdminNotices */
    public $adminNotices;

    /** @var string */
    public $faVersion;

    /**
     * $params['AdminNotices'] AdminNotices
     * $params['faVersion']    string       Font Awesome version semver string
     *
     * @param array $params
     * @throws Exception
     */
    public function __construct(array $params)
    {
        $adminNotices = $params['adminNotices'] ?? null;
        $faVersion = $params['faVersion'] ?? null;

        foreach (['adminNotices', 'faVersion'] as $param) {
            if (!$$param) {
                throw new Exception(
                    __METHOD__ . ' called with missing parameter ' .
                    "`\$params['{$param}']`"
                );
            }
        }

        if (!Version::validate($params['faVersion'])) {
            throw new Exception('Invalid Font Awesome version');
        }

        if (!$params['adminNotices'] instanceof AdminNotices) {
            throw new Exception(
                "`\$params['adminNotices']` must be an instance of AdminNotices"
            );
        }

        $this->adminNotices = $adminNotices;
        $this->faVersion = $faVersion;
    }

    public function addHooks(): void
    {
        $scripts = new Scripts();
        $hooks = new Hooks($this, $scripts);
        $styles = new Styles();

        add_action('admin_notices', function () {
            $this->adminNotices->html($this->pluginName());
        });
        add_action('admin_print_footer_scripts', [$scripts, 'printScripts']);
        add_action('admin_init', [$styles, 'add']);
        add_filter(
            'register_post_type_args',
            static function ($args, $name) use ($hooks) {
                return $hooks->filterRegisterPostTypeArgs($args, $name);
            }, 10, 2
        );
        add_filter('set_url_scheme', static function ($url) use ($hooks) {
            return $hooks->filterSetUrlScheme($url);
        });
    }

    /**
     * @param string $class
     *
     * @return void
     */
    public function addV4SyntaxWarning($class): void
    {
        if ($this->isFaClassV4($class)) {
            $v5Class = $this->faV5Class($class);
            $this->adminNotices->add(
                'FA WP Admin Menu Icons now uses Font Awesome 5! Please ' .
                "replace <code>{$class}</code> with <code>{$v5Class}</code>.",
                'warning'
            );
        }
    }

    /**
     * Test whether a string is a valid Font Awesome v5 class.
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
    public function isFaClass($string): bool
    {
        return (bool)preg_match('/^fa[bsr]\s+fa-[\w-]+$/', $string);
    }

    /**
     * Test whether string uses FA WP Admin Menu Icons v4 syntax, which was
     * simply `'fa-<icon>'` (without the `'fa '` prefix)
     *
     * @param $string
     *
     * @return bool
     */
    public function isFaClassV4($string): bool
    {
        return strpos($string, 'fa-') === 0;
    }

    public function pluginName()
    {
        return get_plugin_data(
            __DIR__ . '/../fa-wp-admin-menu-icons.php'
        )['Name'];
    }

    public function shims(): ?array
    {
        $shims = json_decode(
            file_get_contents(__DIR__ . '/fa-shims.json'),
            true
        );

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
    public function faV5Class($faV4Class)
    {
        if ($this->isFaClass($faV4Class)) {
            return $faV4Class;
        }
        if ($this->isFaClassV4($faV4Class)) {
            $iconName = $this->stripFaPrefix($faV4Class);
            $v5IconName = $this->faV5IconName($iconName);
            $prefix = $this->faV5IconPrefix($iconName);

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
    public function faV5IconName($faV4IconName): string
    {
        if (!$shims = $this->shims()) {
            return $faV4IconName;
        }

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
    public function faV5IconPrefix($faV4IconName): string
    {
        $default = 'fas';

        if (!$shims = $this->shims()) {
            return $default;
        }

        foreach ($shims as $shim) {
            if ($shim['v4Name'] === $faV4IconName) {
                return $shim['v5Prefix'];
            }
        }

        return $default;
    }

    public function stripFaPrefix($string)
    {
        return strpos($string, 'fa-') === 0 ? substr($string, 3) : $string;
    }
}
