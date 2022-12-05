<?php

use Fawpami\Scripts;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Scripts.php';

class ScriptsTest extends TestCase
{
    public function testPrintScripts(): void
    {
        $menuPage = 'fawpamimenupage';
        $postType = 'fawpamiposttype';

        Scripts::registerMenuPage($menuPage);
        Scripts::registerPostType($postType);

        $this->expectOutputRegex("/\.toplevel_page_$menuPage/");
        $this->expectOutputRegex("/\.menu-icon-$postType/");

        Scripts::print();
    }
}
