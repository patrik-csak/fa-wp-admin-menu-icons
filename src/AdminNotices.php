<?php

namespace Fawpami;

class AdminNotices
{
    /** @var array */
    private $notices = [];

    /**
     * @param string $message
     * @param string $style 'error', 'info', 'success', 'warning', or ''
     *
     * @return void
     */
    public function add($message, $style = ''): void
    {
        $this->notices[] = [
            'message' => $message,
            'style' => $style
        ];
    }

    /**
     * @param string $pluginName
     */
    public function html($pluginName): void
    {
        $class = 'notice';

        foreach ($this->notices as $notice) {
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
