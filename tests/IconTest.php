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
    protected function setUp()
    {
        parent::setUp();
        \WP_Mock::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
        \WP_Mock::tearDown();
        \Mockery::close();
    }

    public function testWithBadFaClass(): void
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[isFaClass]',
            [
                [
                    'adminNotices' => new AdminNotices(),
                    'faVersion' => Fawpami::FA_VERSION
                ]
            ]
        );
        $fawpami->shouldReceive('isFaClass')->andReturn(false);

        $this->expectException(Exception::class);

        new Icon([
            'faClass' => 'emosewa',
            'fawpami' => $fawpami
        ]);
    }

    public function testNewBrandIcon(): void
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[isFaClass]',
            [
                [
                    'adminNotices' => new AdminNotices(),
                    'faVersion' => Fawpami::FA_VERSION
                ]
            ]
        );
        $fawpami->shouldReceive('isFaClass')->andReturn(true);

        $this->assertInstanceOf(
            Icon::class,
            new Icon([
                'faClass' => 'fab fa-500px',
                'fawpami' => $fawpami
            ])
        );
    }

    public function testNewRegularIcon(): void
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[isFaClass]',
            [
                [
                    'adminNotices' => new AdminNotices(),
                    'faVersion' => Fawpami::FA_VERSION
                ]
            ]
        );
        $fawpami->shouldReceive('isFaClass')->andReturn(true);

        $this->assertInstanceOf(
            Icon::class,
            new Icon([
                'faClass' => 'far fa-address-book',
                'fawpami' => $fawpami
            ])
        );
    }

    public function testNewSolidIcon(): void
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[isFaClass]',
            [
                [
                    'adminNotices' => new AdminNotices(),
                    'faVersion' => Fawpami::FA_VERSION
                ]
            ]
        );
        $fawpami->shouldReceive('isFaClass')->andReturn(true);

        $this->assertInstanceOf(
            Icon::class,
            new Icon([
                'faClass' => 'fas fa-address-book',
                'fawpami' => $fawpami
            ])
        );
    }

    public function testNewIconWithInvalidClass(): void
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[isFaClass]',
            [
                [
                    'adminNotices' => new AdminNotices(),
                    'faVersion' => Fawpami::FA_VERSION
                ]
            ]
        );
        $fawpami->shouldReceive('isFaClass')->andReturn(false);

        $this->expectException(Exception::class);

        new Icon([
            'faClass' => 'camera-retro',
            'fawpami' => $fawpami
        ]);
    }

    public function testSvgDataUri(): void
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
        $fawpami = new Fawpami([
            'adminNotices' => $adminNotices,
            'faVersion' => Fawpami::FA_VERSION
        ]);
        $icon = new Icon([
            'faClass' => 'fas fa-camera-retro',
            'fawpami' => $fawpami
        ]);

        $this->assertStringStartsWith(
            'data:image/svg+xml;base64,',
            $icon->svgDataUri()
        );
    }

    public function testSvgDataUriWithCachedIcon(): void
    {
        $faVersion = Fawpami::FA_VERSION;
        \WP_Mock::userFunction('get_option', [
            'args' => ["fawpami_icon_camera_retro_solid_{$faVersion}"],
            'return' => 'data:image/svg+xml;base64,'
        ]);

        $adminNotices = new AdminNotices();
        $fawpami = new Fawpami([
            'adminNotices' => $adminNotices,
            'faVersion' => $faVersion
        ]);
        $icon = new Icon([
            'faClass' => 'fas fa-camera-retro',
            'fawpami' => $fawpami
        ]);

        $this->assertStringStartsWith(
            'data:image/svg+xml;base64,',
            $icon->svgDataUri()
        );
    }

    public function testSvgDataUriWithInvalidIcon(): void
    {
        \WP_Mock::userFunction('get_option', ['return' => false]);
        \WP_Mock::userFunction('is_wp_error', ['return' => false]);
        \WP_Mock::userFunction('wp_remote_get', ['return' => []]);
        \WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 404]
        );

        $adminNotices = new AdminNotices();
        $fawpami = new Fawpami([
            'adminNotices' => $adminNotices,
            'faVersion' => Fawpami::FA_VERSION
        ]);
        $icon = new Icon([
            'faClass' => 'fas fa-emosewa',
            'fawpami' => $fawpami
        ]);

        $this->expectException(Exception::class);
        $icon->svgDataUri();
    }

    public function testSvgDataUriWithWpRemoteGetError(): void
    {
        $errorMessage = 'Message from \WP_Error::get_error_message';
        $wpError = Mockery::mock('WP_Error');
        $wpError->shouldReceive('get_error_message')->andReturn($errorMessage);

        \WP_Mock::userFunction('get_option', ['return' => false]);
        \WP_Mock::userFunction('is_wp_error', ['return' => true]);
        \WP_Mock::userFunction('wp_remote_get', ['return' => $wpError]);
        \WP_Mock::userFunction('is_wp_error', ['return' => true]);

        $fawpami = new Fawpami([
            'adminNotices' => new AdminNotices(),
            'faVersion' => Fawpami::FA_VERSION
        ]);
        $icon = new Icon([
            'faClass' => 'fas fa-camera-retro',
            'fawpami' => $fawpami
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage($errorMessage);

        $icon->svgDataUri();
    }
}
