<?php

use Fawpami\AdminNotices;
use Fawpami\Fawpami;
use Fawpami\Hooks;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Fawpami.php';

class FawpamiTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testAddV4SyntaxNotice()
    {
        $adminNotices = Mockery::mock('Fawpami\AdminNotices');
        $adminNotices->shouldReceive('add');
        $fawpami = \Mockery::mock(
            'Fawpami\Fawpami[pluginName]', [$adminNotices]
        );
        $fawpami->shouldReceive('isFaClassV4')->andReturn(true);
        $fawpami->shouldReceive('faV5Class')->andReturn('fas glass-martini');

        $fawpami->addV4SyntaxWarning('fa-glass', $adminNotices);

        $this->assertTrue(true);
    }

    public function testIsFaClassWithSolidIcon()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertTrue($fawpami->isFaClass('fas fa-camera-retro'));
    }

    public function testIsFaClassWithRegularIcon()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertTrue($fawpami->isFaClass('far fa-camera-retro'));
    }

    public function testIsFaClassWithBrandsIcon()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertTrue($fawpami->isFaClass('fab fa-font-awesome'));
    }

    /**
     * This plugin doesn't support Font Awesome Pro yet.
     */
    public function testIsFaClassWithLightIcon()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertFalse($fawpami->isFaClass('fal fa-camera-retro'));
    }

    public function testIsFaClassWithFaV4Syntax()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertFalse($fawpami->isFaClass('fa-camera-retro'));
    }

    public function testIsFaClassWithInvalidSyntax()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertFalse($fawpami->isFaClass('camera-retro'));
    }

    public function testIsFaClassV4WithFaV4Syntax()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertTrue($fawpami->isFaClassV4('fa-camera-retro'));
    }

    public function testIsFaClassV4WithFaV5Syntax()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertFalse($fawpami->isFaClassV4('fas fa-camera-retro'));
    }

    public function testShims()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertArraySubset(
            [
                'v4Name' => 'glass',
                'v5Name' => 'glass-martini',
                'v5Prefix' => 'fas'
            ],
            $fawpami->shims()[0]
        );
    }

    public function testFaV5ClassWithV4Icon()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertEquals(
            'fas fa-address-book',
            $fawpami->faV5Class('fa-address-book')
        );
    }

    public function testFaV5ClassWithV5Class()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertEquals(
            'fas fa-address-book',
            $fawpami->faV5Class('fas fa-address-book')
        );
    }

    public function testFaV5ClassWithInvalidIcon()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertFalse($fawpami->faV5Class('emosewa'));
    }

    public function testFaV5IconName()
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[shims]',
            [new AdminNotices()]
        );
        $fawpami
            ->shouldReceive('shims')
            ->andReturn([
                [
                    'v4Name' => 'glass',
                    'v5Name' => 'glass-martini'
                ]
            ]);

        $this->assertEquals('glass-martini', $fawpami->faV5IconName('glass'));
    }

    public function testFaV5IconNameWithNonExistentIcon()
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[shims]',
            [new AdminNotices()]
        );
        $fawpami
            ->shouldReceive('shims')
            ->andReturnNull();

        $this->assertEquals('emosewa', $fawpami->faV5IconName('emosewa'));
    }

    public function testFaV5IconPrefix()
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[shims]',
            [new AdminNotices()]
        );
        $fawpami
            ->shouldReceive('shims')
            ->andReturn([
                [
                    'v4Name' => 'address-book-o',
                    'v5Prefix' => 'far'
                ]
            ]);

        $this->assertEquals('far', $fawpami->faV5IconPrefix('address-book-o'));
    }

    public function testFaV5IconPrefixWithNonExistentIcon()
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[shims]',
            [new AdminNotices()]
        );
        $fawpami
            ->shouldReceive('shims')
            ->andReturnNull();

        $this->assertEquals('fas', $fawpami->faV5IconPrefix('emosewa'));
    }

    public function testStripFaPrefix()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertEquals(
            'camera-retro',
            $fawpami->stripFaPrefix('fa-camera-retro')
        );
    }

    public function testStripFaPrefixReturnsOriginalStringIfNoPrefix()
    {
        $fawpami = new Fawpami(new AdminNotices());

        $this->assertEquals(
            'camera-retro',
            $fawpami->stripFaPrefix('camera-retro')
        );
    }

    public function testPluginName()
    {
        $fawpami = new Fawpami(new AdminNotices());

        WP_Mock::userFunction('get_plugin_data', [
            'return' => ['Name' => 'FA WP Admin Menu Icons']
        ]);

        $this->assertEquals(
            'FA WP Admin Menu Icons',
            $fawpami->pluginName()
        );
    }
}
