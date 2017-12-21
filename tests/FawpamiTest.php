<?php

use Fawpami\Fawpami;
use PHPUnit\Framework\TestCase;

class FawpamiTest extends TestCase
{
    public function setUp()
    {
        WP_Mock::setUp();
    }

    public function tearDown()
    {
        WP_Mock::tearDown();
    }

    public function testIsFaClassSolid()
    {
        $this->assertTrue(Fawpami::isFaClass('fas fa-camera-retro'));
    }

    public function testIsFaClassRegular()
    {
        $this->assertTrue(Fawpami::isFaClass('far fa-camera-retro'));
    }

    public function testIsFaClassBrands()
    {
        $this->assertTrue(Fawpami::isFaClass('fab fa-font-awesome'));
    }

    /**
     * This plugin doesn't support Font Awesome Pro yet.
     */
    public function testIsFaClassLight()
    {
        $this->assertFalse(Fawpami::isFaClass('fal fa-camera-retro'));
    }

    public function testIsFaClassDeprecated()
    {
        $this->assertFalse(Fawpami::isFaClass('fa-camera-retro'));
    }

    public function testIsFaClassReturnsFalseIfNotFaClass()
    {
        $this->assertFalse(Fawpami::isFaClass('camera-retro'));
    }

    public function testIsFaClassDeprecatedWithDeprecatedSyntax()
    {
        $this->assertTrue(Fawpami::isFaClassDeprecated('fa-camera-retro'));
    }

    public function testIsFaClassDeprecatedWithCurrentSyntax()
    {
        $this->assertFalse(Fawpami::isFaClassDeprecated('fas fa-camera-retro'));
    }

    public function testArrSub()
    {
        $this->assertArraySubset(['a' => 1], [['a' => 1], ['a' => 2]][0]);
    }

    public function testShims()
    {
        $shims = Fawpami::shims();
        $this->assertArraySubset(
          [
            'v4Name'   => 'glass',
            'v5Name'   => 'glass-martini',
            'v5Prefix' => 'fas'
          ],
          $shims[0]
        );
    }

    public function testFaV5Name()
    {
        $expected = 'glass-martini';
        $actual   = Fawpami::faV5IconName('glass');
        $this->assertEquals($expected, $actual);
    }

    public function testFaV5NameNonExistentIcon()
    {
        $icon     = 'emosewa-tnof';
        $expected = $icon;
        $actual   = Fawpami::faV5IconName($icon);
        $this->assertEquals($expected, $actual);
    }

    public function testFaV5Prefix()
    {
        $expected = 'far';
        $actual   = Fawpami::faV5IconPrefix('address-book-o');
        $this->assertEquals($expected, $actual);
    }

    public function testFaV5PrefixNonExistentIcon()
    {
        $expected = 'fas';
        $actual   = Fawpami::faV5IconPrefix('emosewa-tnof');
        $this->assertEquals($expected, $actual);
    }

    public function testStripFaPrefix()
    {
        $expected = 'camera-retro';
        $actual   = Fawpami::stripFaPrefix('fa-camera-retro');
        $this->assertEquals($expected, $actual);
    }

    public function testStripFaPrefixNoopIfNoPrefix()
    {
        $expected = 'camera-retro';
        $actual   = Fawpami::stripFaPrefix('camera-retro');
        $this->assertEquals($expected, $actual);
    }

    public function testPluginName()
    {
        WP_Mock::userFunction('get_plugin_data', [
          'return' => ['Name' => 'The plugin name']
        ]);
        $this->assertInternalType('string', Fawpami::pluginName());
    }
}
