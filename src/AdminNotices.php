<?php

namespace Fawpami;

use function get_plugin_data;

require_once 'AdminNotice.php';

class AdminNotices
{
    /** @var AdminNotice[] */
    private static array $notices = [];

    /**
     * @param string $message
     * @param string $style 'error', 'info', 'success', 'warning', or ''
     *
     * @return void
     */
    public static function add(string $message, string $style = ''): void
    {
        self::$notices[] = new AdminNotice($message, $style);
    }

    public static function print(): void
    {
        $pluginName = get_plugin_data(
            __DIR__ . '/../fa-wp-admin-menu-icons.php'
        )['Name'];

        foreach (self::$notices as $notice) {
            echo <<< HTML
<div class='notice notice-$notice->style'>
    <p><b>$pluginName:</b> $notice->message</p>
</div>
HTML;
        }
    }
}
