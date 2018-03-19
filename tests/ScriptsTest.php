<?php

use Fawpami\Scripts;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Scripts.php';

class ScriptsTest extends TestCase
{
    public function testPrintScripts()
    {
        $menuPage = 'fawpamimenupage';
        $postType = 'fawpamiposttype';
        $scripts = new Scripts();

        $scripts->registerMenuPage($menuPage);
        $scripts->registerPostType($postType);

        $this->expectOutputRegex("/\.toplevel_page_{$menuPage}/");
        $this->expectOutputRegex("/\.menu-icon-{$postType}/");

        $scripts->printScripts();
    }
}
