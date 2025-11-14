<?php
namespace Src\Models;

use Src\Core\Database;
use PDO;

class ModelPergunta
{
    /**
     * Retorna todas as perguntas cadastradas no banco.
     *
     * @return array
     */
    public static function getPerguntas(): array
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("
            SELECT id, texto, tipo, escala_min, escala_max 
            FROM tbpergunta 
            ORDER BY ordem ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
