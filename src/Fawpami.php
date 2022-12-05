<?php

namespace Fawpami;

require_once 'AdminNotices.php';
require_once 'Hooks.php';
require_once 'Scripts.php';
require_once 'Styles.php';

class Fawpami
{
    /** @var string */
    public const FA_VERSION = '5.15.4';

    public static function addHooks(): void
    {
        add_action('admin_notices', [AdminNotices::class, 'print']);
        add_action('admin_print_footer_scripts', [Scripts::class, 'print']);
        add_action('admin_init', [Styles::class, 'add']);

        add_filter(
            'register_post_type_args',
            [Hooks::class, 'filterRegisterPostTypeArgs'],
            10,
            2,
        );
        add_filter('set_url_scheme', [Hooks::class, 'filterSetUrlScheme']);
    }

    /**
     * Test whether a string is a valid Font Awesome v5 class.
     *
     * For Font Awesome v5, the class should look like this:
     * `[fas|far|fab] fa-<icon>`, for example: `fas fa-camera-retro`. See
     * {@link https://fontawesome.com/v5/docs/web/reference-icons/}
     */
    public static function isFaClass(string $string): bool
    {
        return preg_match('/^fa[bsr]\s+fa-[\w-]+$/', $string) === 1;
    }
}
