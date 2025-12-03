<?php

namespace Src\Models;

use Src\Core\conexaobd;
use Src\Core\query;

class ModelPergunta
{

    private $conn;
    private $db;

    public function __construct()
    {
        $this->conn = new conexaobd();
        $this->conn->conecta();
        $this->db = new query($this->conn);
    }

    public function getPerguntas()
    {
        $this->db->setSql("SELECT * FROM tbpergunta ORDER BY ordem ASC");
        $this->db->open();

        $perguntas = [];
        while ($linha = $this->db->getNextRow()) {
            $perguntas[] = $linha;
        }

        return $perguntas;
    }

    public function getPergunta($id){
        $this->db->setSql("SELECT * FROM tbpergunta WHERE id = $id");
        $this->db->open();

        return $this->db->getNextRow() ?: null;
    }

    public function salvar($dados){
        
        if (!empty($dados['id'])) {
            $id         = $dados['id'];
            $escala     = $dados['tipo'];
            $escala_min = $dados['escala_min'] ?? 0;
            $escala_max = $dados['escala_max'] ?? 0;
            $novaOrdem  = $dados['ordem'];

            [$escala, $escala_min, $escala_max] = $this->verificaEscala($escala, $escala_min, $escala_max);

            $iOrdemAntiga = $this->getOdemAntiga($id);

            $ordemExistente = $this->verifica($novaOrdem);

            if ($ordemExistente == 9999) {
                $this->db->update(
                    'tbpergunta',
                    ['texto','tipo','escala_min','escala_max','ordem'],
                    [$dados['texto'],$escala ,$escala_min, $escala_max, $dados['ordem']],
                    "id = {$dados['id']}"
                );
            } else {
                $this->db->update(
                    'tbpergunta',
                    ['ordem'],
                    [9999],
                    "ordem = $ordemExistente"
                );

                $this->db->update(
                    'tbpergunta',
                    ['texto','tipo','escala_min','escala_max','ordem'],
                    [$dados['texto'],$escala ,$escala_min, $escala_max, $novaOrdem],
                    "id = {$dados['id']}"
                );

                $this->db->update(
                    'tbpergunta',
                    ['ordem'],
                    [$iOrdemAntiga],
                    "ordem = 9999"
                );
            }
            
        } else {

            $escala     = $dados['tipo'] ?? null;;
            $escala_min = $dados['escala_min'] ?? 0;
            $escala_max = $dados['escala_max'] ?? 0;

            [$escala, $escala_min, $escala_max] = $this->verificaEscala($escala, $escala_min, $escala_max);
            
            $this->db->insert(
                'tbpergunta',
                ['texto','tipo','escala_min','escala_max','ordem'],
                [$dados['texto'], $escala ,$escala_min ,$escala_max ,$dados['ordem']]
            );
        }
        
    }

    public function verificaExisteOrdem($ordem, $id = null) {
        $ordem = (int)$ordem;
    
        $this->db->setSql("SELECT id FROM tbpergunta WHERE ordem = $ordem");
        $this->db->open();
        $existe = $this->db->getNextRow();
    
        if (!$existe) {
            return null;
        }
    
        if ($id && $existe['id'] == $id) { 
            return null;
        }
   
        return "Já existe uma pergunta com a ordem $ordem!";
    }
    
    public function verificaEscala($escala, $escala_max, $escala_min) {
        if ($escala == 'escala_10') {
            $escala = 'escala';
            $escala_min = 0;
            $escala_max = 10;
        }

        if ($escala == 'escala_5') {
            $escala = 'escala';
            $escala_min = 0;
            $escala_max = 5;
        }

        if ($escala == 'aberta') {
            $escala = 'aberta';
            $escala_min = 0;
            $escala_max = 0;
        }
        return [$escala, $escala_min, $escala_max];
    }

    public function getOdemAntiga($id) {    

        $this->db->setSql("SELECT * FROM tbpergunta WHERE id = $id");
        $this->db->open();

       $aDadosAnteriores =  $this->db->getNextRow();
       return $ordemAntiga = $aDadosAnteriores['ordem'];
    }

    public function verifica($ordem) {
       $this->db->setSql("SELECT * FROM tbpergunta WHERE ordem = $ordem");
       $this->db->open();

       $aDados = $this->db->getNextRow();
       $ordemExistente = 9999;
        
       if ($aDados) {
        return $ordemExistente = $aDados['ordem'];
       }
       return $ordemExistente;
    }


    public function excluir($id){
        $this->db->delete('tbpergunta', "id = $id");
    }

    public function __destruct()
    {
            $this->conn->desconecta();
    }
}