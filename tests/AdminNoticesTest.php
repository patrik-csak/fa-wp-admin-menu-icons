<?php

use Fawpami\AdminNotices;
use Fawpami\Fawpami;
use PHPUnit\Framework\TestCase;

class AdminNoticesTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        WP_Mock::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
        WP_Mock::tearDown();
    }

    public function testHtml()
    {
        WP_Mock::userFunction('get_plugin_data', [
            'return' => ['Name' => 'FA WP Admin Menu Icons']
        ]);

        $message = 'Test';
        $pluginName = Fawpami::pluginName();

        AdminNotices::add($message, 'info');

        $this->expectOutputString(<<< HTML
<div class='notice notice-info'>
    <p><b>{$pluginName}:</b> {$message}</p>
</div>
HTML
        );

        AdminNotices::html();
    }
}
