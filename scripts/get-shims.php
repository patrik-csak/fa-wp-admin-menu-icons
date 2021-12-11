<?php

namespace Fawpami;

require_once __DIR__ . '/../src/Fawpami.php';
require_once __DIR__ . '/../src/Version.php';

$faVersion = Fawpami::FA_VERSION;

if (Version::lessThan($faVersion, '5.0.0')) {
    echo "No shims file created for version {$faVersion} because shims were " .
        'introduced in Font Awesome v5.';
    exit(1);
}

if (Version::lessThan($faVersion, '5.6.0')) {
    $filename = 'https://raw.githubusercontent.com/FortAwesome/Font-Awesome/' .
        "{$faVersion}/advanced-options/metadata/shims.json";
} else {
    $filename = 'https://raw.githubusercontent.com/FortAwesome/Font-Awesome/' .
        "{$faVersion}/metadata/shims.json";
}

$file = file_get_contents($filename);

file_put_contents(__DIR__ . '/../src/fa-shims.json', $file);
