<?php

use Fawpami\AdminNotices;
use Fawpami\Fawpami;
use Fawpami\Hooks;
use PHPUnit\Framework\TestCase;

class FawpamiTest extends TestCase
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
    }

    public function testAddHooks()
    {
        WP_Mock::expectActionAdded(
            'admin_notices',
            [AdminNotices::class, 'html']
        );
        WP_Mock::expectFilterAdded(
            'register_post_type_args',
            [Hooks::class, 'filterRegisterPostTypeArgs']
        );
        WP_Mock::expectFilterAdded(
            'set_url_scheme',
            [Hooks::class, 'filterSetUrlScheme']
        );

        Fawpami::addHooks();

        $this->assertTrue(true);
    }

    public function testIsFaClassWithSolidIcon()
    {
        $this->assertTrue(Fawpami::isFaClass('fas fa-camera-retro'));
    }

    public function testIsFaClassWithRegularIcon()
    {
        $this->assertTrue(Fawpami::isFaClass('far fa-camera-retro'));
    }

    public function testIsFaClassWithBrandsIcon()
    {
        $this->assertTrue(Fawpami::isFaClass('fab fa-font-awesome'));
    }

    /**
     * This plugin doesn't support Font Awesome Pro yet.
     */
    public function testIsFaClassWithLightIcon()
    {
        $this->assertFalse(Fawpami::isFaClass('fal fa-camera-retro'));
    }

    public function testIsFaClassWithFaV4Syntax()
    {
        $this->assertFalse(Fawpami::isFaClass('fa-camera-retro'));
    }

    public function testIsFaClassReturnsFalseIfNotFaClass()
    {
        $this->assertFalse(Fawpami::isFaClass('camera-retro'));
    }

    public function testIsFaClassDeprecatedWithFaV4Syntax()
    {
        $this->assertTrue(Fawpami::isFaClassV4('fa-camera-retro'));
    }

    public function testIsFaClassDeprecatedWithFaV5Syntax()
    {
        $this->assertFalse(Fawpami::isFaClassV4('fas fa-camera-retro'));
    }

    public function testShims()
    {
        $this->assertArraySubset(
            [
                'v4Name' => 'glass',
                'v5Name' => 'glass-martini',
                'v5Prefix' => 'fas'
            ],
            Fawpami::shims()[0]
        );
    }

    public function testFaV5ClassWithV4Icon()
    {
        $this->assertEquals(
            'fas fa-address-book',
            Fawpami::faV5Class('fa-address-book')
        );
    }

    public function testFaV5ClassWithV5Class()
    {
        $this->assertEquals(
            'fas fa-address-book',
            Fawpami::faV5Class('fas fa-address-book')
        );
    }

    public function testFaV5ClassWithInvalidIcon()
    {
        $this->assertFalse(Fawpami::faV5Class('emosewa'));
    }

    public function testFaV5IconName()
    {
        $this->assertEquals('glass-martini', Fawpami::faV5IconName('glass'));
    }

    public function testFaV5IconNameWithNonExistentIcon()
    {
        $this->assertEquals('emosewa', Fawpami::faV5IconName('emosewa'));
    }

    public function testFaV5IconPrefix()
    {
        $this->assertEquals('far', Fawpami::faV5IconPrefix('address-book-o'));
    }

    public function testFaV5IconPrefixWithNonExistentIcon()
    {
        $this->assertEquals('fas', Fawpami::faV5IconPrefix('emosewa'));
    }

    public function testStripFaPrefix()
    {
        $this->assertEquals(
            'camera-retro',
            Fawpami::stripFaPrefix('fa-camera-retro')
        );
    }

    public function testStripFaPrefixReturnsOriginalStringIfNoPrefix()
    {
        $this->assertEquals(
            'camera-retro',
            Fawpami::stripFaPrefix('camera-retro')
        );
    }

    public function testPluginName()
    {
        WP_Mock::userFunction('get_plugin_data', [
            'return' => ['Name' => 'FA WP Admin Menu Icons']
        ]);

        $this->assertEquals('FA WP Admin Menu Icons', Fawpami::pluginName());
    }
}
