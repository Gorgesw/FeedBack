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
    
            $erro = $this->model->verificaExisteOrdem(
                $_POST['ordem'],
                $_POST['id'] ?? null
            );
    
            if ($erro) {
                return $this->aviso($erro);
            }
    
            $this->model->salvar($_POST);
    
            return $this->aviso("Pergunta salva com sucesso!");
        }
    
        return $this->aviso("Requisição inválida.");
    }
    
    

    public function aviso($mensagem)
{
    $this->view('aviso', ['mensagem' => $mensagem]);
}


    public function excluir($id){

        $id = $id ?? $_GET['id'] ?? null;

        if ($id) {
            $this->model->excluir((int) $id);
        }

        return $this->aviso("Pergunta excluída com sucesso!");

    }

}
