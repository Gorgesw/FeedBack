<?php
namespace Src\Core;

class Router
{
    public function run()
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        if ($uri === '') $uri = 'index';
    
        $parts = explode('/', $uri);
        $controllerPart = $parts[0] ?? 'index';
        $methodPart     = $parts[1] ?? 'index';
        $param          = $parts[2] ?? null; 
        $controllerName = "Controller" . str_replace(' ', '', ucwords(str_replace('_', ' ', $controllerPart)));
        $fullClass = "Src\\Controllers\\$controllerName";
        $file = __DIR__ . "/../Controllers/class_controller_{$controllerPart}.php";
    
        if (!file_exists($file)) {
            require __DIR__ . "/../Views/404.view.php";
            return;
        }
    
        require $file;
        $controller = new $fullClass();
    
        if (method_exists($controller, $methodPart)) {

            if ($param !== null) {
                $controller->$methodPart($param);
            } else {
                $controller->$methodPart();
            }
        } else {
            $controller->index();
        }
    }
}
