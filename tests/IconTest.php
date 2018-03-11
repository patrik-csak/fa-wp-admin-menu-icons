<?php

use Fawpami\Exception;
use Fawpami\Icon;
use PHPUnit\Framework\TestCase;

class IconTest extends TestCase
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

    public function testNewBrandIcon()
    {
        $this->assertInstanceOf(
            Icon::class,
            new Icon('fab fa-500px')
        );
    }

    public function testNewRegularIcon()
    {
        $this->assertInstanceOf(
            Icon::class,
            new Icon('far fa-address-book')
        );
    }

    public function testNewSolidIcon()
    {
        $this->assertInstanceOf(
            Icon::class,
            new Icon('fas fa-address-book')
        );
    }

    public function testBadConstructorCall()
    {
        $this->expectException(Exception::class);
        new Icon('camera-retro');
    }

    public function testSvgDataUri()
    {
        \WP_Mock::userFunction('add_option', ['return' => true]);
        \WP_Mock::userFunction('get_option', ['return' => false]);
        \WP_Mock::userFunction('is_wp_error', ['return' => false]);
        \WP_Mock::userFunction('wp_remote_get', [
            'return' => [
                'body' => '<svg xmlns="http://www.w3.org/2000/svg"></svg>'
            ]
        ]);
        \WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 200]
        );

        $this->assertStringStartsWith(
            'data:image/svg+xml;base64,',
            (new Icon('fas fa-camera-retro'))->svgDataUri()
        );
    }

    public function testSvgDataUriWithCachedIcon()
    {
        \WP_Mock::userFunction('get_option', [
            'args' => ['fawpami_icon_camera_retro_solid'],
            'return' => 'data:image/svg+xml;base64,'
        ]);

        $this->assertStringStartsWith(
            'data:image/svg+xml;base64,',
            (new Icon('fas fa-camera-retro'))->svgDataUri()
        );
    }

    public function testSvgDataUriWithInvalidIcon()
    {
        \WP_Mock::userFunction('get_option', ['return' => false]);
        \WP_Mock::userFunction('is_wp_error', ['return' => false]);
        \WP_Mock::userFunction('wp_remote_get', ['return' => []]);
        \WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 404]
        );

        $this->expectException(Exception::class);
        (new Icon('fas fa-emosewa'))->svgDataUri();
    }
}
