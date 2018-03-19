<?php

use Fawpami\Styles;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Styles.php';

class StylesTest extends TestCase
{
    public function testAdd()
    {
        WP_Mock::userFunction('wp_add_inline_style', ['return' => true]);

        (new Styles())->add();

        $this->assertTrue(true);
    }
}
