<?php
spl_autoload_register(function ($class) {
    if (strpos($class, 'Src\\') !== 0) return;

    $baseDir = __DIR__ . '/../Src/';
    $relative = substr($class, 4);
    $parts = explode('\\', $relative);
    $className = array_pop($parts);
    $dir = implode('/', $parts);

    $file = '';

    // MODEL
    if (strpos($className, 'Model') === 0) {
        $fileName = strtolower(substr($className, 5));
        $file = $baseDir . $dir . "/class_model_{$fileName}.php";
    }

    // CONTROLLER 
    elseif (strpos($className, 'Controller') === 0 && $className !== 'Controller') {
        $fileName = strtolower(substr($className, 10));
        $file = $baseDir . $dir . "/class_controller_{$fileName}.php";
    }

    // CORE
    elseif ($className === 'Router') {
        $file = $baseDir . $dir . "/class_router.php";
    }
    elseif ($className === 'Controller') {
        $file = $baseDir . $dir . "/class_controller.php";
    }

    // DATABASE 
    elseif ($className === 'Database') {
        $file = $baseDir . $dir . "/class_database.php";
    }

    if ($file !== '' && file_exists($file)) {
        require $file;
    }
});