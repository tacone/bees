#!/usr/bin/env php
<?php

/*
 * This script will install the right version of Orchestral depending on
 * the Laravel version you want to test with.
 *
 * WARNING! In order to update the dependencies, it will remove the vendor
 * folder of this package.
 *
 * Sample usage:
 *
 * ```bash
 * cd vendor/tacone/bees
 * scripts/test-with-laravel 5.1
 * phpunit
 * ```
 */
chdir(__DIR__ . '/..');

$laravelVersion = !empty($argv[1]) ? $argv[1] : '';
if (!$laravelVersion) {
    echo "You need to supply a Laravel version as the first parameter, for instance: 5.1" . PHP_EOL;
    echo PHP_EOL;
    exit(1);
}

echo "Bootstrapping package to test with Laravel $laravelVersion";
echo PHP_EOL;

if (!file_exists('composer.phar')) {
    echo 'downloading composer:' . PHP_EOL;
    passthru('php -r "readfile(\'https://getcomposer.org/installer\');" | php');
}
echo PHP_EOL;

echo "Backupping composer.json" . PHP_EOL;
passthru("cp composer.json composer.json.backup");

if (strpos($laravelVersion, '.')) {
    $tokens = explode('.', $laravelVersion);
    $tokens[0] -= 2;
    $orchestralVersion = join('.', array_slice($tokens, 0, 2)).'.*';
} else {
    $orchestralVersion = $laravelVersion;
}

if (file_exists('vendor')) {
    echo "Removing vendor folder..." . PHP_EOL;
    passthru("rm vendor -rf");
}

echo "Installing Orchestral $orchestralVersion: " . PHP_EOL;
passthru("php composer.phar require orchestra/testbench '$orchestralVersion'");

echo "Installing Faker" . PHP_EOL;
passthru("php composer.phar require fzaninotto/faker '@stable'");

echo "Reverting composer.json" . PHP_EOL;
passthru("cp composer.json composer.json.test");
passthru("cp composer.json.backup composer.json");
passthru("rm composer.json.backup");


