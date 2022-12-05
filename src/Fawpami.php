<?php

namespace Fawpami;

require_once 'AdminNotices.php';
require_once 'Hooks.php';
require_once 'Scripts.php';
require_once 'Styles.php';

class Fawpami
{
    /** @var string */
    public const FONT_AWESOME_VERSION = '6.2.1';

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
}
