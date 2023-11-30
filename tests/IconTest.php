<?php

use Fawpami\Fawpami;
use Fawpami\Icon;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Icon.php';

class IconTest extends TestCase
{
    /**
     * @dataProvider nonFontAwesomeClassesProvider
     */
    public function testFromClassWithNonFontAwesomeClass(string $string): void
    {
        $this->assertNull(Icon::fromClass($string));
    }

    /**
     * @dataProvider fontAwesomeClassesProvider
     */
    public function testFromClassWithFontAwesomeClass(string $string): void
    {
        $this->assertInstanceOf(Icon::class, Icon::fromClass($string));
    }

    public function testGetSvgDataUri(): void
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

        $icon = Icon::fromClass('fa-solid fa-user');

        $this->assertStringStartsWith(
            'data:image/svg+xml;base64,',
            $icon->getSvgDataUri()
        );
    }

    public function testGetSvgDataUriWithCachedIcon(): void
    {
        WP_Mock::userFunction('get_option', [
            'args' => ['fawpami_icon_user_solid_' . Fawpami::FONT_AWESOME_VERSION],
            'return' => 'data:image/svg+xml;base64,'
        ]);

        $icon = Icon::fromClass('fa-solid fa-user');

        $this->assertStringStartsWith(
            'data:image/svg+xml;base64,',
            $icon->getSvgDataUri()
        );
    }

    public function testGetSvgDataUriWithWpRemoteGetError(): void
    {
        $errorMessage = 'Message from \WP_Error::get_error_message';
        $wpError = Mockery::mock('WP_Error');
        $wpError->shouldReceive('get_error_message')->andReturn($errorMessage);

        WP_Mock::userFunction('get_option', ['return' => false]);
        WP_Mock::userFunction('is_wp_error', ['return' => true]);
        WP_Mock::userFunction('wp_remote_get', ['return' => $wpError]);
        WP_Mock::userFunction('wp_remote_retrieve_body', ['return' => '']);
        WP_Mock::userFunction('is_wp_error', ['return' => true]);

        $icon = Icon::fromClass('fa-solid fa-user');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage($errorMessage);

        $icon->getSvgDataUri();
    }

    public static function nonFontAwesomeClassesProvider(): array
    {
        return [
            ['dashicons-admin-users'],
            ['fa fa-user'], // font awesome v4 syntax
            ['user'],
        ];
    }

    /**
     * @link https://fontawesome.com/docs/web/add-icons/how-to#setting-different-families-styles
     */
    public static function fontAwesomeClassesProvider(): array
    {
        return [
            ['fa-regular fa-user'],
            ['far fa-user'],
            ['fa-solid fa-user'],
            ['fas fa-user'],
            ['fa-brands fa-font-awesome'],
            ['fab fa-font-awesome'],
        ];
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
