<?php

$cacheDir = __DIR__ . '/cache/twig';

if (is_dir($cacheDir)) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($cacheDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($files as $fileinfo) {
        $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
        $todo($fileinfo->getRealPath());
    }

    rmdir($cacheDir);
    mkdir($cacheDir, 0775, true);
    echo "Cache de Twig eliminada.\n";
} else {
    mkdir($cacheDir, 0775, true);
    echo "Creado directorio de cache de Twig.\n";
}