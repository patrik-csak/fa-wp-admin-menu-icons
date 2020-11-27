<?php

namespace Fawpami;

class Version
{
    public static function different(string $a, string $b): bool
    {
        $vA = self::parse($a);
        $vB = self::parse($b);

        return $vA['major'] !== $vB['major'] ||
               $vA['minor'] !== $vB['minor'] ||
               $vA['patch'] !== $vB['patch'];
    }

    public static function lessThan(string $a, string $b): bool
    {
        $vA = self::parse($a);
        $vB = self::parse($b);

        foreach (['major', 'minor', 'patch'] as $version) {
            if ($vA[$version] > $vB[$version]) {
                return false;
            }

            if ($vA[$version] < $vB[$version]) {
                return true;
            }

            // Versions match, continue to next version part
        }

        return false;
    }

    private static function parse(string $version): array
    {
        preg_match(
            '/^(?<major>\d+)\.(?<minor>\d+)\.(?<patch>\d+)$/',
            $version,
            $matches
        );

        return [
            'major' => (int)$matches['major'],
            'minor' => (int)$matches['minor'],
            'patch' => (int)$matches['patch'],
        ];
    }

    public static function validate(string $version): bool
    {
        return (bool)preg_match('/^\d+\.\d+\.\d+$/', $version);
    }
}
