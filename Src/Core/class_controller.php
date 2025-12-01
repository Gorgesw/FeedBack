<?php
namespace Src\Core;

class Controller
{

    protected function view(string $viewName, array $data = []): void
    {
        extract($data);

        $viewFile = "view_{$viewName}.php";
        $viewPath = __DIR__ . "/../Views/{$viewFile}";

        if (!file_exists($viewPath)) {
            die("Erro: View '{$viewFile}' não encontrada em: $viewPath");
        }

        require $viewPath;
    }
  
    protected function model(string $model): object
    {
        $modelFile = "class_model_{$model}.php";
        $modelPath = __DIR__ . "/../Models/{$modelFile}";

        if (!file_exists($modelPath)) {
            die("Erro: Model '{$model}' não encontrado em: $modelPath");
        }

        require_once $modelPath;

        $className = "Src\\Models\\Model" . ucfirst($model);
        return new $className();
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}