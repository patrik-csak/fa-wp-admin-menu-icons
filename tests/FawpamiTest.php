<?php

use Fawpami\Fawpami;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Fawpami.php';

class FawpamiTest extends TestCase
{
    private Fawpami $fawpami;

    public function testConstruct(): void
    {
        $this->assertInstanceOf(Fawpami::class, $this->fawpami);
    }

    public function testIsFaClassWithSolidIcon(): void
    {
        $this->assertTrue(Fawpami::isFaClass('fas fa-camera-retro'));
    }

    public function testIsFaClassWithRegularIcon(): void
    {
        $this->assertTrue(Fawpami::isFaClass('far fa-camera-retro'));
    }

    public function testIsFaClassWithBrandsIcon(): void
    {
        $this->assertTrue(Fawpami::isFaClass('fab fa-font-awesome'));
    }

    /**
     * This plugin doesn't support Font Awesome Pro yet.
     */
    public function testIsFaClassWithLightIcon(): void
    {
        $this->assertFalse(Fawpami::isFaClass('fal fa-camera-retro'));
    }

    public function testIsFaClassWithFaV4Syntax(): void
    {
        $this->assertFalse(Fawpami::isFaClass('fa-camera-retro'));
    }

    public function testIsFaClassWithInvalidSyntax(): void
    {
        $this->assertFalse(Fawpami::isFaClass('camera-retro'));
    }

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
}
