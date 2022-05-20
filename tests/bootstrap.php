<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

deleteFiles(__DIR__ . '/tmp');

function deleteFiles(string $path): void
{
    foreach (array_filter((array) glob($path . '/*')) as $file) {
        is_dir($file) ? deleteFiles($file) : unlink($file);
        @rmdir($file);
    }
}
