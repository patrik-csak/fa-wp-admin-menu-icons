<?php

use Fawpami\AdminNotices;
use Fawpami\Fawpami;
use Fawpami\Hooks;
use Fawpami\Scripts;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Fawpami.php';

class HooksTest extends TestCase
{
    /** @var string */
    private $svgDataUriPrefix = 'data:image/svg+xml;base64,';

    protected function setUp()
    {
        parent::setUp();
        \WP_Mock::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
        \WP_Mock::tearDown();
        unset($GLOBALS['admin_page_hooks']);
    }

    public function testFilterRegisterPostTypeArgsWithoutMenuIcon()
    {
        $fawpami = new Fawpami(new AdminNotices());
        $scripts = new Scripts();
        $hooks = new Hooks($fawpami, $scripts);

        $this->assertEquals([], $hooks->filterRegisterPostTypeArgs([], ''));
    }

    public function testFilterRegisterPostTypeArgsWithInvalidMenuIcon()
    {
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

        $adminNotices = \Mockery::mock('Fawpami\AdminNotices');
        $adminNotices->shouldReceive('add');

        $fawpami = \Mockery::mock(
            'Fawpami\Fawpami[isFaClass,isFaClassV4]',
            [$adminNotices]
        );
        $fawpami->shouldReceive('isFaClass')->andReturn(true);
        $fawpami->shouldReceive('isFaClassV4')->andReturn(false);

        $scripts = \Mockery::mock('Fawpami\Scripts');
        $scripts->shouldReceive('registerPostType');

        $hooks = new Hooks($fawpami, $scripts);

        $args = $hooks->filterRegisterPostTypeArgs(
            ['menu_icon' => 'fas fa-emosewa'],
            ''
        );

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $args['menu_icon']
        );
    }

    public function testFilterRegisterPostTypeArgsWithValidMenuIcon()
    {
        \WP_Mock::userFunction(
            'get_option',
            ['return' => $this->svgDataUriPrefix]
        );

        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[isFaClass,isFaClassV4]',
            [new AdminNotices()]
        );
        $fawpami->shouldReceive('isFaClass')->andReturn(true);
        $fawpami->shouldReceive('isFaClassV4')->andReturn(false);

        $scripts = \Mockery::mock('Fawpami\Scripts');
        $scripts->shouldReceive('registerPostType');

        $hooks = new Hooks($fawpami, $scripts);

        $args = $hooks->filterRegisterPostTypeArgs(
            ['menu_icon' => 'fas fa-camera-retro'],
            ''
        );

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $args['menu_icon']
        );
    }

    public function testFilterRegisterPostTypeArgsWithValidFaV4MenuIcon()
    {
        \WP_Mock::userFunction(
            'get_option',
            ['return' => $this->svgDataUriPrefix]
        );

        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[addV4SyntaxWarning,faV5Class,isFaClass,isFaClassV4]',
            [new AdminNotices()]
        );
        $fawpami->shouldReceive('addV4SyntaxWarning')->andReturnNull();
        $fawpami->shouldReceive('faV5Class')->andReturn('far fa-address-book');
        $fawpami->shouldReceive('isFaClass')->andReturn(false, true);
        $fawpami->shouldReceive('isFaClassV4')->andReturn(true, false);

        $scripts = \Mockery::mock('Fawpami\Scripts');
        $scripts->shouldReceive('registerPostType');

        $hooks = new Hooks($fawpami, $scripts);

        $args = $hooks->filterRegisterPostTypeArgs(
            ['menu_icon' => 'fa-address-book'],
            ''
        );

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $args['menu_icon']
        );
    }

    public function testFilterSetUrlSchemeWithoutIcon()
    {
        $adminNotices = new AdminNotices();

        $fawpami = Mockery::mock('Fawpami\Fawpami', [$adminNotices]);
        $fawpami->shouldReceive('isFaClass')->andReturn(false);
        $fawpami->shouldReceive('isFaClassV4')->andReturn(false);

        $scripts = Mockery::mock('Fawpami\Scripts');
        $scripts->shouldReceive('registerMenuPage');

        $hooks = new Hooks($fawpami, $scripts);

        $url = 'http://www.example.com';

        $this->assertEquals($url, $hooks->filterSetUrlScheme($url));
    }

    public function testFilterSetUrlSchemeWithInvalidMenuIcon()
    {
        $GLOBALS['admin_page_hooks'] = ['a' => 'a'];

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

        $adminNotices = \Mockery::mock('Fawpami\AdminNotices');
        $adminNotices->shouldReceive('add');

        $fawpami = \Mockery::mock('Fawpami\Fawpami', [$adminNotices]);
        $fawpami
            ->shouldReceive('faV5Class')
            ->andReturn('fas fa-glass-martini');
        $fawpami->shouldReceive('isFaClass')->andReturn(true);
        $fawpami->shouldReceive('isFaClassV4')->andReturn(false);

        $scripts = Mockery::mock('Fawpami\Scripts');
        $scripts->shouldReceive('registerMenuPage');

        $hooks = new Hooks($fawpami, $scripts);

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $hooks->filterSetUrlScheme('fas fa-emosewa')
        );
    }

    public function testFilterSetUrlSchemeWithValidMenuIcon()
    {
        $GLOBALS['admin_page_hooks'] = ['a' => 'a'];

        \WP_Mock::userFunction(
            'get_option',
            ['return' => $this->svgDataUriPrefix]
        );

        $adminNotices = new AdminNotices();

        $fawpami = Mockery::mock('Fawpami\Fawpami', [$adminNotices]);
        $fawpami->shouldReceive('isFaClass')->andReturn(true);
        $fawpami->shouldReceive('isFaClassV4')->andReturn(false);

        $scripts = Mockery::mock('Fawpami\Scripts');
        $scripts->shouldReceive('registerMenuPage');

        $hooks = new Hooks($fawpami, $scripts);

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $hooks->filterSetUrlScheme('fas fa-camera-retro')
        );
    }

    public function testFilterSetUrlSchemeWithValidFaV4MenuIcon()
    {
        $GLOBALS['admin_page_hooks'] = ['a' => 'a'];

        \WP_Mock::userFunction(
            'get_option',
            ['return' => $this->svgDataUriPrefix]
        );

        $adminNotices = new AdminNotices();

        $fawpami = Mockery::mock('Fawpami\Fawpami', [$adminNotices]);
        $fawpami->shouldReceive('addV4SyntaxWarning');
        $fawpami
            ->shouldReceive('faV5Class')
            ->andReturn('fas fa-glass-martini');
        $fawpami->shouldReceive('isFaClass')->andReturn(true);
        $fawpami->shouldReceive('isFaClassV4')->andReturn(true);

        $scripts = Mockery::mock();
        $scripts->shouldReceive('registerMenuPage');

        $hooks = new Hooks($fawpami, $scripts);

        $this->assertStringStartsWith(
            $this->svgDataUriPrefix,
            $hooks->filterSetUrlScheme('fa-glass')
        );
    }
}
