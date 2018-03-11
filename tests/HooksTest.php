<?php

use Fawpami\Hooks;
use PHPUnit\Framework\TestCase;

class HooksTest extends TestCase
{
    /** @var string */
    private $emptySvg = '<svg xmlns="http://www.w3.org/2000/svg"></svg>';

    /** @var string */
    private $svgDataUriPrefix = 'data:image/svg+xml;base64,';

    public function setUp()
    {
        parent::setUp();
        \WP_Mock::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
        \WP_Mock::tearDown();
    }

    public function testFilterRegisterPostTypeArgsWithoutMenuIcon()
    {
        $this->assertEquals([], Hooks::filterRegisterPostTypeArgs([]));
    }

    public function testFilterRegisterPostTypeArgsWithValidMenuIcon()
    {
        \WP_Mock::userFunction('add_option', ['return' => true]);
        \WP_Mock::userFunction('get_option', ['return' => false]);
        \WP_Mock::userFunction('is_wp_error', ['return' => false]);
        \WP_Mock::userFunction(
            'wp_remote_get',
            ['return' => ['body' => $this->emptySvg]]
        );
        \WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 200]
        );

        $args = Hooks::filterRegisterPostTypeArgs(
            ['menu_icon' => 'fas fa-camera-retro']
        );

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $args['menu_icon']
        );
    }

    public function testFilterRegisterPostTypeArgsWithInvalidMenuIcon()
    {
        \WP_Mock::userFunction('add_option', ['return' => true]);
        \WP_Mock::userFunction(
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
        \WP_Mock::userFunction('is_wp_error', ['return' => false]);
        \WP_Mock::userFunction('wp_remote_get', ['return' => []]);
        \WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 404]
        );

        $args = Hooks::filterRegisterPostTypeArgs([
            'menu_icon' => 'fas fa-emosewa'
        ]);

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $args['menu_icon']
        );
    }

    public function testFilterRegisterPostTypeArgsWithValidFaV4MenuIcon()
    {
        \WP_Mock::userFunction('add_option', ['return' => true]);
        \WP_Mock::userFunction('get_option', ['return' => false]);
        \WP_Mock::userFunction('is_wp_error', ['return' => false]);
        \WP_Mock::userFunction(
            'wp_remote_get',
            ['return' => ['body' => $this->emptySvg]]
        );
        \WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 200]
        );

        $args = Hooks::filterRegisterPostTypeArgs(
            ['menu_icon' => 'fa-camera-retro']
        );

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $args['menu_icon']
        );
    }

    public function testFilterRegisterPostTypeArgsWithInvalidFaV4MenuIcon()
    {
        \WP_Mock::userFunction('add_option', ['return' => false]);
        \WP_Mock::userFunction(
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
        \WP_Mock::userFunction('is_wp_error', ['return' => false]);
        \WP_Mock::userFunction('wp_remote_get', ['return' => []]);
        \WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 404]
        );

        $args = Hooks::filterRegisterPostTypeArgs(
            ['menu_icon' => 'fa-emosewa']
        );

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $args['menu_icon']
        );
    }

    public function testFilterSetUrlSchemeWithoutIcon()
    {
        $url = 'http://www.example.com';
        $this->assertEquals($url, Hooks::filterSetUrlScheme($url));
    }

    public function testFilterSetUrlSchemeWithValidMenuIcon()
    {
        \WP_Mock::userFunction('add_option', ['return' => true]);
        \WP_Mock::userFunction('get_option', ['return' => false]);
        \WP_Mock::userFunction('is_wp_error', ['return' => false]);
        \WP_Mock::userFunction(
            'wp_remote_get',
            ['return' => ['body' => $this->emptySvg]]
        );
        \WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 200]
        );

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            Hooks::filterSetUrlScheme('fas fa-camera-retro')
        );
    }

    public function testFilterSetUrlSchemeWithInvalidMenuIcon()
    {
        \WP_Mock::userFunction('add_option', ['return' => true]);
        \WP_Mock::userFunction(
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
        \WP_Mock::userFunction('is_wp_error', ['return' => false]);
        \WP_Mock::userFunction('wp_remote_get', ['return' => []]);
        \WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 404]
        );

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            Hooks::filterSetUrlScheme('fas fa-emosewa')
        );
    }

    public function testFilterSetUrlSchemeWithValidFaV4MenuIcon()
    {
        \WP_Mock::userFunction('add_option', ['return' => true]);
        \WP_Mock::userFunction('get_option', ['return' => false]);
        \WP_Mock::userFunction('is_wp_error', ['return' => false]);
        \WP_Mock::userFunction(
            'wp_remote_get',
            ['return' => ['body' => $this->emptySvg]]
        );
        \WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 200]
        );

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            Hooks::filterSetUrlScheme('fa-camera-retro')
        );
    }

    public function testFilterSetUrlSchemeWithDeprecatedInvalidFaV4MenuIcon()
    {
        \WP_Mock::userFunction('add_option', ['return' => true]);
        \WP_Mock::userFunction(
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
        \WP_Mock::userFunction('is_wp_error', ['return' => false]);
        \WP_Mock::userFunction('wp_remote_get', ['return' => []]);
        \WP_Mock::userFunction(
            'wp_remote_retrieve_response_code',
            ['return' => 404]
        );

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            Hooks::filterSetUrlScheme('fa-emosewa')
        );
    }
}
