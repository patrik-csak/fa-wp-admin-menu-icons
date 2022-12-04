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

        $this->fawpami = new Fawpami();
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
