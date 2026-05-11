<?php

require_once __DIR__ . '/../vendor/autoload.php';

$base = __DIR__ . '/../src/Ksfraser/';

spl_autoload_register(function ($class) use ($base) {
    $prefix = 'Ksfraser\\';
    if (strpos($class, $prefix) === 0) {
        $rel = str_replace($prefix, '', $class);
        $path = $base . str_replace('\\', '/', $rel) . '.php';
        if (file_exists($path)) require $path;
    }
});
