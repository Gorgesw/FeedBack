<?php
namespace Src\Controllers;

use Src\Core\Controller;
use Src\Models\ModelResposta;

class ControllerEnviaAvaliacao extends Controller
{
    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/');
            return;
        }

        try {
            $oModelResposta = new ModelResposta();
            $oModelResposta->salvarRespostas($_POST);
            $this->redirect('/agradecimento');
        } catch (\Exception $e) {
            $_SESSION['erro'] = 'Erro ao enviar.';
            $this->redirect('/avaliacao');
        }
    }
}