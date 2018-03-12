<?php

namespace Fawpami;

final class AdminNotices
{
    private static $notices = [];

    /**
     * @param string $message
     * @param string $style 'error', 'info', 'success', 'warning', or ''
     */
    public static function add($message, $style = '')
    {
        self::$notices[] = [
            'message' => $message,
            'style' => $style
        ];
    }

    public static function clear()
    {
        self::$notices = [];
    }

    public static function html()
    {
        $class = 'notice';
        $pluginName = Fawpami::pluginName();

        foreach (self::$notices as $notice) {
            $style = $notice['style'];

            if (in_array($style, ['error', 'info', 'success', 'warning'])) {
                $class .= " notice-{$style}";
            }
            echo <<< HTML
<div class='{$class}'>
    <p><b>{$pluginName}:</b> {$notice['message']}</p>
</div>
HTML;
        }
    }
}