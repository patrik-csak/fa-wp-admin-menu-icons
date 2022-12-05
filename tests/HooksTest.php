<?php

use Fawpami\AdminNotices;
use Fawpami\Fawpami;
use Fawpami\Hooks;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Fawpami.php';

class HooksTest extends TestCase
{
    /** @var string */
    private $svgDataUriPrefix = 'data:image/svg+xml;base64,';

    protected function setUp(): void
    {
        parent::setUp();
        WP_Mock::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        WP_Mock::tearDown();
        unset($GLOBALS['admin_page_hooks']);
    }

    public function testFilterRegisterPostTypeArgsWithoutMenuIcon(): void
    {
        $this->assertEquals([], Hooks::filterRegisterPostTypeArgs([], ''));
    }

    public function testFilterRegisterPostTypeArgsWithInvalidMenuIcon(): void
    {
        WP_Mock::userFunction(
            'get_option',
            [
                'return_in_order' => [
                    // No cached icon the first time through
                    false,
                    // Cached icon when setting the danger icon due to the 404
                    $this->svgDataUriPrefix
                ]
            ]
        );
        WP_Mock::userFunction('is_wp_error', ['return' => false]);
        WP_Mock::userFunction('wp_remote_get', ['return' => []]);
        WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 404]
        );

        $args = Hooks::filterRegisterPostTypeArgs(
            ['menu_icon' => 'fas fa-emosewa'],
            ''
        );

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $args['menu_icon']
        );
    }

    public function testFilterRegisterPostTypeArgsWithValidMenuIcon(): void
    {
        WP_Mock::userFunction(
            'get_option',
            ['return' => $this->svgDataUriPrefix]
        );

        $args = Hooks::filterRegisterPostTypeArgs(
            ['menu_icon' => 'fas fa-camera-retro'],
            ''
        );

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $args['menu_icon']
        );
    }

    public function testFilterSetUrlSchemeWithoutIcon(): void
    {
        $url = 'https://example.com';

        $this->assertEquals($url, Hooks::filterSetUrlScheme($url));
    }

    public function testFilterSetUrlSchemeWithInvalidMenuIcon(): void
    {
        $GLOBALS['admin_page_hooks'] = ['a' => 'a'];

        WP_Mock::userFunction(
            'get_option',
            [
                'return_in_order' => [
                    // No cached icon the first time through
                    false,
                    // Cached icon when setting the danger icon due to the 404
                    $this->svgDataUriPrefix
                ]
            ]
        );
        WP_Mock::userFunction('is_wp_error', ['return' => false]);
        WP_Mock::userFunction('wp_remote_get', ['return' => []]);
        WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 404]
        );

        $adminNotices = Mockery::mock(AdminNotices::class);
        $adminNotices->shouldReceive('add');

        $hooks = new Hooks();

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $hooks->filterSetUrlScheme('fas fa-emosewa')
        );
    }

    public function testFilterSetUrlSchemeWithValidMenuIcon(): void
    {
        $GLOBALS['admin_page_hooks'] = ['a' => 'a'];

        WP_Mock::userFunction(
            'get_option',
            ['return' => $this->svgDataUriPrefix]
        );

        $hooks = new Hooks();

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $hooks->filterSetUrlScheme('fas fa-camera-retro')
        );
    }
}
