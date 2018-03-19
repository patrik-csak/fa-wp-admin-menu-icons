<?php

use Fawpami\AdminNotices;
use Fawpami\Exception;
use Fawpami\Fawpami;
use Fawpami\Icon;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Fawpami.php';
require_once __DIR__ . '/../src/Icon.php';

class IconTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        \WP_Mock::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
        \WP_Mock::tearDown();
        \Mockery::close();
    }

    public function testNewBrandIcon()
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[isFaClass]',
            [new AdminNotices()]
        );
        $fawpami->shouldReceive('isFaClass')->andReturn(true);

        $this->assertInstanceOf(
            Icon::class,
            new Icon('fab fa-500px', $fawpami)
        );
    }

    public function testNewRegularIcon()
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[isFaClass]',
            [new AdminNotices()]
        );
        $fawpami->shouldReceive('isFaClass')->andReturn(true);

        $this->assertInstanceOf(
            Icon::class,
            new Icon('far fa-address-book', $fawpami)
        );
    }

    public function testNewSolidIcon()
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[isFaClass]',
            [new AdminNotices()]
        );
        $fawpami->shouldReceive('isFaClass')->andReturn(true);

        $this->assertInstanceOf(
            Icon::class,
            new Icon('fas fa-address-book', $fawpami)
        );
    }

    public function testNewIconWithInvalidClass()
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[isFaClass]',
            [new AdminNotices()]
        );
        $fawpami->shouldReceive('isFaClass')->andReturn(false);

        $this->expectException(Exception::class);
        new Icon('camera-retro', $fawpami);
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

        $adminNotices = new AdminNotices();
        $fawpami = new Fawpami($adminNotices);
        $icon = new Icon('fas fa-camera-retro', $fawpami);

        $this->assertStringStartsWith(
            'data:image/svg+xml;base64,',
            $icon->svgDataUri()
        );
    }

    public function testSvgDataUriWithCachedIcon()
    {
        \WP_Mock::userFunction('get_option', [
            'args' => ['fawpami_icon_camera_retro_solid'],
            'return' => 'data:image/svg+xml;base64,'
        ]);

        $adminNotices = new AdminNotices();
        $fawpami = new Fawpami($adminNotices);
        $icon = new Icon('fas fa-camera-retro', $fawpami);

        $this->assertStringStartsWith(
            'data:image/svg+xml;base64,',
            $icon->svgDataUri()
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

        $adminNotices = new AdminNotices();
        $fawpami = new Fawpami($adminNotices);
        $icon = new Icon('fas fa-emosewa', $fawpami);

        $this->expectException(Exception::class);
        $icon->svgDataUri();
    }
}
