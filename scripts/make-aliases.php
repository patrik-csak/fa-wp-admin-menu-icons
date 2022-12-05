<?php

require_once __DIR__ . '/../src/Fawpami.php';

use Fawpami\Fawpami;

$metadata = file_get_contents(
    'https://raw.githubusercontent.com/FortAwesome/Font-Awesome/' .
    Fawpami::FONT_AWESOME_VERSION . '/metadata/icons.json'
);

$metadata = json_decode(
    $metadata,
    associative: true,
    flags: JSON_THROW_ON_ERROR,
);

$aliases = [];

foreach ($metadata as $name => $metadatum) {
    if (!isset($metadatum['aliases']['names'])) {
        continue;
    }

    foreach ($metadatum['aliases']['names'] as $alias) {
        $aliases[$alias] = $name;
    }
}

file_put_contents(
    __DIR__ . '/../src/aliases.json',
    json_encode($aliases, flags: JSON_THROW_ON_ERROR),
);
