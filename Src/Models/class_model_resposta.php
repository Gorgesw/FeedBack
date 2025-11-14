<?php
namespace Src\Models;

use Src\Core\Database;

class ModelResposta
{
    public static function salvarRespostas(array $post): void
    {
        $respostas = $post['resposta'] ?? $post;
        $pdo = Database::getInstance();
        $pdo->beginTransaction();

        try {
            $stmt = $pdo->prepare("INSERT INTO tbavaliacao (criado_em) VALUES (NOW()) RETURNING id");
            $stmt->execute();
            $idAvaliacao = $stmt->fetchColumn();

            $stmt = $pdo->prepare("
                INSERT INTO tbresposta (id_avaliacao, id_pergunta, valor, texto, criado_em)
                VALUES (:avaliacao, :pergunta, :valor, :texto, NOW())
            ");

            foreach ($respostas as $idPergunta => $resposta) {
                $valor = is_numeric($resposta) ? (int)$resposta : null;
                $texto = !is_numeric($resposta) ? trim($resposta) : null;
                if ($texto === '') $texto = null;

                $stmt->execute([
                    ':avaliacao' => $idAvaliacao,
                    ':pergunta'  => $idPergunta,
                    ':valor'     => $valor,
                    ':texto'     => $texto
                ]);
            }

            $pdo->commit();
        } catch (\Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}