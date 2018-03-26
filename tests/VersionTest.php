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
    public function testDifferent($a, $b, $expected)
    {
        $this->assertEquals($expected, Version::different($a, $b));
    }

    /**
     * @dataProvider validateProvider
     *
     * @param string $version
     * @param bool $expected
     */
    public function testValidate($version, $expected)
    {
        $this->assertEquals($expected, Version::validate($version));
    }

    public function differentProvider()
    {
        return [
            ['1.2.3', '1.2.3', false],
            ['1.2.3', '1.2.4', true],
            ['1.2.3', '1.2.0', true],
        ];
    }

    public function validateProvider()
    {
        return [
            ['1.2.3', true],
            ['1.2', false],
            ['1', false]
        ];
    }
}
