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
            $this->db->update(
                'tbpergunta',
                ['texto','tipo','escala_min','escala_max','ordem'],
                [$dados['texto'],$dados['tipo'],$dados['escala_min'],$dados['escala_max'],$dados['ordem']],
                "id = {$dados['id']}"
            );
        } else {
            $this->db->insert(
                'tbpergunta',
                ['texto','tipo','escala_min','escala_max','ordem'],
                [$dados['texto'],$dados['tipo'],$dados['escala_min'],$dados['escala_max'],$dados['ordem']]
            );
        }
    }

    public function excluir($id){
        $this->db->delete('tbpergunta', "id = $id");
    }

    public function __destruct()
    {
        $this->conn->desconecta();
    }
}