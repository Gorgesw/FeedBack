<?php
namespace Src\Core;

class Router
{
    public static function run(): void
    {
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if ($path === '') {
            $path = 'index';
        }

        $controllerFile = __DIR__ . '/../Controllers/class_controller_' . strtolower($path) . '.php';


        if (!file_exists($controllerFile)) {
            http_response_code(404);
            echo "<h1>Erro 404</h1><p>Página não encontrada.</p>";
            return;
        }

        require_once $controllerFile;

        $className = 'Controller' . str_replace(' ', '', ucwords(str_replace('_', ' ', $path)));
        $controllerClass = "Src\\Controllers\\{$className}";
        

        if (!class_exists($controllerClass)) {
            echo "<h1>Erro</h1><p>Controller '$controllerClass' não encontrado.</p>";
            return;
        }

        $controller = new $controllerClass();
        if (method_exists($controller, 'index')) {
            $controller->index();
        } else {
            echo "<h1>Erro</h1><p>Método 'index' não encontrado no controller.</p>";
        }
    }
}
