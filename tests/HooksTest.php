<?php

use Fawpami\Hooks;
use PHPUnit\Framework\TestCase;

class HooksTest extends TestCase
{
    private $svgDataUriPrefix = 'data:image/svg+xml;base64,';

    public function testFilterRegisterPostTypeArgsWithoutMenuIcon()
    {
        $expected = [];
        $actual   = Hooks::filterRegisterPostTypeArgs([]);
        $this->assertEquals($expected, $actual);
    }

    public function testFilterRegisterPostTypeArgsWithValidMenuIcon()
    {
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
        $args = Hooks::filterRegisterPostTypeArgs(
          ['menu_icon' => 'fas fa-emosewa-tnof']
        );
        $this->assertStringStartsWith(
          $this->svgDataUriPrefix,
          $args['menu_icon']
        );
    }

    public function testFilterRegisterPostTypeArgsWithDeprecatedValidMenuIcon()
    {
        $args = Hooks::filterRegisterPostTypeArgs(
          ['menu_icon' => 'fa-camera-retro']
        );
        $this->assertStringStartsWith(
          $this->svgDataUriPrefix,
          $args['menu_icon']
        );
    }

    public function testFilterRegisterPostTypeArgsWithDeprecatedInvalidMenuIcon(
    )
    {
        $args = Hooks::filterRegisterPostTypeArgs(
          ['menu_icon' => 'fa-emosewa-tnof']
        );
        $this->assertStringStartsWith(
          $this->svgDataUriPrefix,
          $args['menu_icon']
        );
    }

    public function testFilterSetUrlSchemeWithoutIcon()
    {
        $url      = 'http://www.example.com';
        $expected = $url;
        $actual   = Hooks::filterSetUrlScheme($url);
        $this->assertEquals($expected, $actual);
    }

    public function testFilterSetUrlSchemeWithValidMenuIcon()
    {
        $url    = 'fas fa-camera-retro';
        $actual = Hooks::filterSetUrlScheme($url);
        $this->assertStringStartsWith($this->svgDataUriPrefix, $actual);
    }

    public function testFilterSetUrlSchemeWithInvalidMenuIcon()
    {
        $url    = 'fas fa-emosewa-tnof';
        $actual = Hooks::filterSetUrlScheme($url);
        $this->assertStringStartsWith($this->svgDataUriPrefix, $actual);
    }

    public function testFilterSetUrlSchemeWithDeprecatedValidMenuIcon()
    {
        $url    = 'fa-camera-retro';
        $actual = Hooks::filterSetUrlScheme($url);
        $this->assertStringStartsWith($this->svgDataUriPrefix, $actual);
    }

    public function testFilterSetUrlSchemeWithDeprecatedInvalidMenuIcon()
    {
        $url    = 'fa-emosewa-tnof';
        $actual = Hooks::filterSetUrlScheme($url);
        $this->assertStringStartsWith($this->svgDataUriPrefix, $actual);
    }
}
