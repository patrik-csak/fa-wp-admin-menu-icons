<?php

use Fawpami\Version;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Version.php';

class VersionTest extends TestCase
{
    /**
     * @dataProvider differentProvider
     *
     * @param string $a
     * @param string $b
     * @param bool $expected
     */
    public function testDifferent($a, $b, $expected): void
    {
        $this->assertEquals($expected, Version::different($a, $b));
    }

    /**
     * @dataProvider lessThanProvider
     *
     * @param string $a
     * @param string $b
     * @param bool $expected
     */
    public function testLessThan($a, $b, $expected): void
    {
        $this->assertEquals($expected, Version::lessThan($a, $b));
    }

    /**
     * @dataProvider validateProvider
     *
     * @param string $version
     * @param bool $expected
     */
    public function testValidate($version, $expected): void
    {
        $this->assertEquals($expected, Version::validate($version));
    }

    public function differentProvider(): array
    {
        return [
            ['1.2.3', '1.2.3', false],
            ['1.2.3', '1.2.4', true],
            ['1.2.3', '1.2.0', true],
        ];
    }

    public function lessThanProvider(): array
    {
        return [
            ['1.2.3', '1.2.3', false],
            ['1.2.3', '1.2.4', true],
            ['1.2.3', '1.2.0', false],
        ];
    }

    public function validateProvider(): array
    {
        return [
            ['1.2.3', true],
            ['1.2', false],
            ['1', false],
        ];
    }
}
