<?php

use Fawpami\AdminNotices;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/AdminNotices.php';

class AdminNoticesTest extends TestCase
{
    protected function setUp(): void
    {
        WP_Mock::setUp();
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
    }

    public function testPrint(): void
    {
        // given
        $message = 'Test';
        $style = 'info';
        $pluginName = 'FA WP Admin Menu Icons';

        // then
        WP_Mock::userFunction('get_plugin_data', [
            'times' => 1,
            'return' => ['Name' => $pluginName],
        ]);
        $this->expectOutputString(
            <<< HTML
<div class='notice notice-$style'>
    <p><b>$pluginName:</b> $message</p>
</div>
HTML
        );

        // when
        AdminNotices::add($message, $style);
        AdminNotices::print();
    }
}
