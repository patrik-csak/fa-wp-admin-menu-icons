<?php

use Fawpami\AdminNotices;
use Fawpami\Exception;
use Fawpami\Fawpami;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Fawpami.php';

class FawpamiTest extends TestCase
{
    /** @var Fawpami */
    private $fawpami;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fawpami = new Fawpami([
            'adminNotices' => new AdminNotices(),
            'faVersion' => Fawpami::FA_VERSION
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testConstruct(): void
    {
        $this->assertInstanceOf(Fawpami::class, $this->fawpami);
    }

    public function testConstructWithBadAdminNotices(): void
    {
        $this->expectException(Exception::class);

        new Fawpami([
            'adminNotices' => 'not an instance of AdminNotices',
            'faVersion' => Fawpami::FA_VERSION
        ]);
    }

    public function testConstructWithBadFaVersion(): void
    {
        $this->expectException(Exception::class);

        new Fawpami([
            'adminNotices' => new AdminNotices(),
            'faVersion' => '5'
        ]);
    }

    public function testConstructWithoutAdminNotices(): void
    {
        $this->expectException(Exception::class);

        new Fawpami([
            'faVersion' => Fawpami::FA_VERSION
        ]);
    }

    public function testConstructWithoutFaVersion(): void
    {
        $this->expectException(Exception::class);

        new Fawpami([
            'adminNotices' => new AdminNotices(),
        ]);
    }

    public function testAddV4SyntaxNotice(): void
    {
        $adminNotices = Mockery::mock(AdminNotices::class);
        $adminNotices->shouldReceive('add');
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[pluginName]',
            [
                [
                    'adminNotices' => $adminNotices,
                    'faVersion' => Fawpami::FA_VERSION
                ]
            ]
        );
        $fawpami->shouldReceive('isFaClassV4')->andReturn(true);
        $fawpami->shouldReceive('faV5Class')->andReturn('fas glass-martini');

        $fawpami->addV4SyntaxWarning('fa-glass', $adminNotices);

        $this->assertTrue(true);
    }

    public function testIsFaClassWithSolidIcon(): void
    {
        $this->assertTrue($this->fawpami->isFaClass('fas fa-camera-retro'));
    }

    public function testIsFaClassWithRegularIcon(): void
    {
        $this->assertTrue($this->fawpami->isFaClass('far fa-camera-retro'));
    }

    public function testIsFaClassWithBrandsIcon(): void
    {
        $this->assertTrue($this->fawpami->isFaClass('fab fa-font-awesome'));
    }

    /**
     * This plugin doesn't support Font Awesome Pro yet.
     */
    public function testIsFaClassWithLightIcon(): void
    {
        $this->assertFalse($this->fawpami->isFaClass('fal fa-camera-retro'));
    }

    public function testIsFaClassWithFaV4Syntax(): void
    {
        $this->assertFalse($this->fawpami->isFaClass('fa-camera-retro'));
    }

    public function testIsFaClassWithInvalidSyntax(): void
    {
        $this->assertFalse($this->fawpami->isFaClass('camera-retro'));
    }

    public function testIsFaClassV4WithFaV4Syntax(): void
    {
        $this->assertTrue($this->fawpami->isFaClassV4('fa-camera-retro'));
    }

    public function testIsFaClassV4WithFaV5Syntax(): void
    {
        $this->assertFalse($this->fawpami->isFaClassV4('fas fa-camera-retro'));
    }

    public function testShims(): void
    {
        $this->assertEquals(
            [
                'v4Name' => 'glass',
                'v5Name' => 'glass-martini',
                'v5Prefix' => 'fas',
            ],
            $this->fawpami->shims()[0]
        );
    }

    public function testFaV5ClassWithV4Icon(): void
    {
        $this->assertEquals(
            'fas fa-address-book',
            $this->fawpami->faV5Class('fa-address-book')
        );
    }

    public function testFaV5ClassWithV5Class(): void
    {
        $this->assertEquals(
            'fas fa-address-book',
            $this->fawpami->faV5Class('fas fa-address-book')
        );
    }

    public function testFaV5ClassWithInvalidIcon(): void
    {
        $this->assertFalse($this->fawpami->faV5Class('emosewa'));
    }

    public function testFaV5IconName(): void
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[shims]',
            [
                [
                    'adminNotices' => new AdminNotices(),
                    'faVersion' => Fawpami::FA_VERSION
                ]
            ]
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

    public function testFaV5IconNameWithNonExistentIcon(): void
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[shims]',
            [
                [
                    'adminNotices' => new AdminNotices(),
                    'faVersion' => Fawpami::FA_VERSION
                ]
            ]
        );
        $fawpami
            ->shouldReceive('shims')
            ->andReturnNull();

        $this->assertEquals('emosewa', $fawpami->faV5IconName('emosewa'));
    }

    public function testFaV5IconPrefix(): void
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[shims]',
            [
                [
                    'adminNotices' => new AdminNotices(),
                    'faVersion' => Fawpami::FA_VERSION
                ]
            ]
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

    public function testFaV5IconPrefixWithNonExistentIcon(): void
    {
        $fawpami = Mockery::mock(
            'Fawpami\Fawpami[shims]',
            [
                [
                    'adminNotices' => new AdminNotices(),
                    'faVersion' => Fawpami::FA_VERSION
                ]
            ]
        );
        $fawpami
            ->shouldReceive('shims')
            ->andReturnNull();

        $this->assertEquals('fas', $fawpami->faV5IconPrefix('emosewa'));
    }

    public function testStripFaPrefix(): void
    {
        $this->assertEquals(
            'camera-retro',
            $this->fawpami->stripFaPrefix('fa-camera-retro')
        );
    }

    public function testStripFaPrefixReturnsOriginalStringIfNoPrefix(): void
    {
        $this->assertEquals(
            'camera-retro',
            $this->fawpami->stripFaPrefix('camera-retro')
        );
    }

    public function testPluginName(): void
    {
        WP_Mock::userFunction('get_plugin_data', [
            'return' => ['Name' => 'FA WP Admin Menu Icons']
        ]);

        $this->assertEquals(
            'FA WP Admin Menu Icons',
            $this->fawpami->pluginName()
        );
    }
}
