<?php
namespace Src\Controllers;

use Src\Core\Controller;
use Src\Models\ModelPergunta;

class ControllerPergunta extends Controller
{
    private $model;

    public function __construct(){
        $this->model = new ModelPergunta();
    }

    public function index(){
        $perguntas = $this->model->getPerguntas();
        $this->view('gerenciar_perguntas', ['perguntas' => $perguntas]);
    }

    public function form(){
        $id = $_GET['id'] ?? null;
        $pergunta = $id ? $this->model->getPergunta((int) $id) : null;
        $this->view('manutencao_pergunta', ['pergunta' => $pergunta]); 
    }


    public function salvar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->salvar($_POST);
        }
        $this->redirect('/pergunta');
    }

    public function excluir($id){

        $id = $id ?? $_GET['id'] ?? null;

        if ($id) {
            $this->model->excluir((int) $id);
        }

        $this->redirect('/pergunta');
    }

}
