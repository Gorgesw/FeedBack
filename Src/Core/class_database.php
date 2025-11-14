<?php
namespace Src\Core;

use PDO;
use PDOException;

class Database {
    private static $pdo = null;

    public static function getInstance() {
        if (self::$pdo === null) {
            try {
                $host = 'localhost';
                $port = '5432';
                $dbname = 'feedback';
                $user = 'postgres';
                $pass = '072511';

                self::$pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão com o banco: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
