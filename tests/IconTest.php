<?php

use Fawpami\Exception;
use Fawpami\Icon;
use PHPUnit\Framework\TestCase;

class IconTest extends TestCase
{
    public function testNewIcon()
    {
        $actual   = new Icon('fas fa-camera-retro');
        $expected = Icon::class;
        $this->assertInstanceOf($expected, $actual);
    }

    public function testBadConstructorCall()
    {
        $this->expectException(Exception::class);
        new Icon('camera-retro');
    }

    public function testSvgDataUri()
    {
        $string = (new Icon('fas fa-camera-retro'))->svgDataUri();
        $this->assertStringStartsWith('data:image/svg+xml;base64,', $string);
    }

    public function testSvgDataUriNonExistentIcon()
    {
        $this->expectException(Exception::class);
        (new Icon('fas fa-emosewa-tnof'))->svgDataUri();
    }
}
