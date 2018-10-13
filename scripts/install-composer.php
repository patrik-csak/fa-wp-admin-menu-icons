<?php

chdir(__DIR__ . '/..');

$setupFile = 'composer-setup.php';
$expectedSignature = trim(file_get_contents('https://composer.github.io/installer.sig'));

copy('https://getcomposer.org/installer', $setupFile);

$actualSignature = hash_file('SHA384', $setupFile);

if ($expectedSignature !== $actualSignature) {
    echo 'ERROR: Invalid installer signature';
    unlink($setupFile);
    exit (1);
}

include $setupFile;
