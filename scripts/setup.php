#!/usr/bin/env php
<?php

declare(strict_types=1);

const DEFAULT_PACKAGE_NAME = 'vendor/cloudbase-plugin';
const DEFAULT_NAMESPACE = 'Vendor\\CloudBasePlugin\\';

function ask(string $question, string $default = ''): string
{
    echo $question . ($default ? " [$default]" : '') . ': ';
    $answer = trim(fgets(STDIN));
    return $answer !== '' ? $answer : $default;
}

$root = dirname(__DIR__);
$composerFile = "$root/composer.json";

if (!file_exists($composerFile)) {
    echo "composer.json not found!\n";
    exit(1);
}

$composer = json_decode(file_get_contents($composerFile), true);
$packageName = ask('Package name (vendor/package)', DEFAULT_PACKAGE_NAME);
$namespace   = ask('PHP namespace (PSR-4)', DEFAULT_NAMESPACE);
$composer['name'] = $packageName;
$composer['autoload']['psr-4'] = [
    $namespace => 'src/'
];

file_put_contents($composerFile, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "✅ Updated composer.json\n";

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator("$root/src", FilesystemIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getRealPath());
        $updated = str_replace('CloudBase\Skeleton', rtrim($namespace, '\\'), $content);
        $updated = str_replace('@cloudbase/skeleton', $packageName, $updated);

        if ($updated !== $content) {
            file_put_contents($file->getRealPath(), $updated);
        }
    }
}

echo "✅ Replaced namespace references in src/\n";

$servicesFile = "$root/config/services.yaml";

if (file_exists($servicesFile)) {
    $content = file_get_contents($servicesFile);
    $updated = str_replace('CloudBase\\Skeleton', rtrim($namespace, '\\'), $content);

    if ($updated !== $content) {
        file_put_contents($servicesFile, $updated);
        echo "✅ Updated namespace in config/services.yaml\n";
    }
}

echo "\n🎉 Plugin skeleton setup complete!\n";
