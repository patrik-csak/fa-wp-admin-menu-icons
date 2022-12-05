<?php

use Fawpami\Exception;
use Fawpami\Fawpami;
use Fawpami\Icon;
use PHPUnit\Framework\TestCase;

class IconTest extends TestCase
{
    public function testWithBadFaClass(): void
    {
        $fawpami = Mockery::mock('Fawpami\Fawpami[isFaClass]');
        $fawpami->shouldReceive('isFaClass')->andReturn(false);

        $this->expectException(Exception::class);

        new Icon('emosewa');
    }

    public function testNewBrandIcon(): void
    {
        $fawpami = Mockery::mock('Fawpami\Fawpami[isFaClass]');
        $fawpami->shouldReceive('isFaClass')->andReturn(true);

        $this->assertInstanceOf(
            Icon::class,
            new Icon('fab fa-500px'),
        );
    }

    public function testNewRegularIcon(): void
    {
        $fawpami = Mockery::mock('Fawpami\Fawpami[isFaClass]');
        $fawpami->shouldReceive('isFaClass')->andReturn(true);

        $this->assertInstanceOf(
            Icon::class,
            new Icon('far fa-address-book'),
        );
    }

    public function testNewSolidIcon(): void
    {
        $fawpami = Mockery::mock('Fawpami\Fawpami[isFaClass]');
        $fawpami->shouldReceive('isFaClass')->andReturn(true);

        $this->assertInstanceOf(
            Icon::class,
            new Icon('fas fa-address-book'),
        );
    }

    public function testNewIconWithInvalidClass(): void
    {
        $fawpami = Mockery::mock('Fawpami\Fawpami[isFaClass]');
        $fawpami->shouldReceive('isFaClass')->andReturn(false);

        $this->expectException(Exception::class);

        new Icon('camera-retro');
    }

    public function testSvgDataUri(): void
    {
        $body = '<svg xmlns="http://www.w3.org/2000/svg"></svg>';

        WP_Mock::userFunction('add_option', ['return' => true]);
        WP_Mock::userFunction('get_option', ['return' => false]);
        WP_Mock::userFunction('is_wp_error', ['return' => false]);
        WP_Mock::userFunction('wp_remote_get', ['return' => ['body' => $body]]);
        WP_Mock::userFunction('wp_remote_retrieve_body', ['return' => $body]);
        WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 200],
        );

        $icon = new Icon('fas fa-camera-retro');

        $this->assertStringStartsWith(
            'data:image/svg+xml;base64,',
            $icon->getSvgDataUri()
        );
    }

    public function testSvgDataUriWithCachedIcon(): void
    {
        WP_Mock::userFunction('get_option', [
            'args' => ['fawpami_icon_camera-retro_solid_' . Fawpami::FA_VERSION],
            'return' => 'data:image/svg+xml;base64,'
        ]);

        $icon = new Icon('fas fa-camera-retro');

        $this->assertStringStartsWith(
            'data:image/svg+xml;base64,',
            $icon->getSvgDataUri()
        );
    }

    public function testSvgDataUriWithInvalidIcon(): void
    {
        WP_Mock::userFunction('get_option', ['return' => false]);
        WP_Mock::userFunction('is_wp_error', ['return' => false]);
        WP_Mock::userFunction('wp_remote_get', ['return' => []]);
        WP_Mock::userFunction('wp_remote_retrieve_body', ['return' => '']);
        WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 404]
        );

        $icon = new Icon('fas fa-emosewa');

        $this->expectException(Exception::class);
        $icon->getSvgDataUri();
    }

    public function testSvgDataUriWithWpRemoteGetError(): void
    {
        $errorMessage = 'Message from \WP_Error::get_error_message';
        $wpError = Mockery::mock('WP_Error');
        $wpError->shouldReceive('get_error_message')->andReturn($errorMessage);

        WP_Mock::userFunction('get_option', ['return' => false]);
        WP_Mock::userFunction('is_wp_error', ['return' => true]);
        WP_Mock::userFunction('wp_remote_get', ['return' => $wpError]);
        WP_Mock::userFunction('wp_remote_retrieve_body', ['return' => '']);
        WP_Mock::userFunction('is_wp_error', ['return' => true]);

        $icon = new Icon('fas fa-camera-retro');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage($errorMessage);

        $icon->getSvgDataUri();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WP_Mock::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        WP_Mock::tearDown();
        Mockery::close();
    }
}
