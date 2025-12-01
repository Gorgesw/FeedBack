<?php

namespace Src\Models;

use Src\Core\conexaobd;
use Src\Core\query;

class ModelResposta
{
    public function salvarRespostas(array $post)
    {
        $respostas = $post['resposta']; 
    
        $conn = new conexaobd();
        $conn->conecta();
        $db = new query($conn);
    
        $db->insert('tbavaliacao', ['criado_em'], ['NOW()']);
        $db->setSql("SELECT id FROM tbavaliacao ORDER BY criado_em DESC LIMIT 1");
        $db->open();
        $idAvaliacao = ($db->getNextRow()['id'] ?? null);
    
        if (!$idAvaliacao) {
            $conn->desconecta();
            return;
        }
    
        foreach ($respostas as $idPergunta => $resposta) {
            $valor = null;
            $texto = null;
        
            if (is_numeric($resposta)) {
                $valor = (int) $resposta;   
            } else {
      
            $resposta = trim($resposta);
                if ($resposta !== '') {             
                    $texto = $resposta;
            }
           
            }
        
            $db->insert('tbresposta', 
                ['id_avaliacao', 'id_pergunta', 'valor', 'texto', 'criado_em'],
                [$idAvaliacao, $idPergunta, $valor, $texto, 'NOW()']
            );
        }
    
        $conn->desconecta();
    }
}