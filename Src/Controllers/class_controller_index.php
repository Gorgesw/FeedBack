<?php
namespace Src\Controllers;

use Src\Core\Controller;
use Src\Models\ModelPergunta;

class ControllerIndex extends Controller {

    /**
     * Exibe a página inicial.
     *
     * @return void
     */
    public function index()
    {
        $this->model('pergunta'); 
        $aPerguntas = new ModelPergunta();
        $aPerguntas = $aPerguntas->getPerguntas(); 

        $this->view('avaliacao', ['perguntas' => $aPerguntas]);
    }
}
