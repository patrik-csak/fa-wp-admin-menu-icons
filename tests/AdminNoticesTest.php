<?php

use Fawpami\AdminNotices;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/AdminNotices.php';

class AdminNoticesTest extends TestCase
{
    public function testHtml(): void
    {
        $message = 'Test';
        $pluginName = 'FA WP Admin Menu Icons';
        $adminNotices = new AdminNotices();

        $adminNotices->add($message, 'info');

        $this->expectOutputString(
            <<< HTML
<div class='notice notice-info'>
    <p><b>{$pluginName}:</b> {$message}</p>
</div>
HTML
        );

        $adminNotices->html($pluginName);
    }
}
