<?php

spl_autoload_register(function ($class) {

    if (strpos($class, 'Src\\') !== 0) return;

    $base = __DIR__ . '/../Src/';
    $parts = explode('\\', $class);

    $type = strtolower($parts[1]);
    $name = strtolower($parts[2]);  

    if ($type === 'controllers') {
        $file = $base . "Controllers/class_controller_" . substr($name, 10) . ".php";
    } elseif ($type === 'models') {
        $file = $base . "Models/class_model_" . substr($name, 5) . ".php";
    } else {
        $file = $base . "Core/class_" . $name . ".php";
    }

    if (file_exists($file)) require $file;
});
