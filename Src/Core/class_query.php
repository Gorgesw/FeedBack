<?php

namespace Src\Core;


class query {
    private $sql;
    private $registros;
    private $connection;
    private $queryResource;

    public function __construct($oConn) {
        $this->registros = 0;
        $this->connection = $oConn;
    }

    public function open() {
        $this->queryResource = pg_query($this->connection->getInternalConnection(), $this->sql);
        if ($this->queryResource) {
            // Retorna a quantidade de linhas da query.
            $this->registros = pg_num_rows($this->queryResource);
            return true;
        }
        return false;
    }

    public function getNextRow() {
        $row = pg_fetch_assoc($this->queryResource);
        if ($row) {
            return $row;
        }
        return false;
    }


    public function update($stabela, $aColunas, $aValores, $sWhere) {
        $setClauses = [];
        for ($i = 0; $i < count($aColunas); $i++) {
            $setClauses[] = $aColunas[$i] . ' = $' . ($i + 1);
        }
        $setString = implode(', ', $setClauses);

        $result = pg_query_params($this->connection->getInternalConnection(),
                                  "UPDATE " . $stabela . " SET " . $setString . " WHERE " . $sWhere,
                                  $aValores);
        return $result;
    }

    public function insert($sTabela, $aColunas, $aValores) {
        $colString = implode(', ', $aColunas);
        $paramMarkers = [];
        for ($i = 1; $i <= count($aValores); $i++) {
            $paramMarkers[] = '$' . $i;
        }
        $paramString = implode(', ', $paramMarkers);

        $result = pg_query_params($this->connection->getInternalConnection(),
                                  "INSERT INTO " . $sTabela . " (" . $colString . ") VALUES (" . $paramString . ")",
                                  $aValores);
        return $result;
    }

    public function delete($sTabela, $sWhere) {
        $result = pg_query($this->connection->getInternalConnection(),
                           "DELETE FROM " . $sTabela . " WHERE " . $sWhere);
        return $result;
        
    }

    public function getRegistros() {
        return $this->registros;
    }

    public function setSql($sSql) {
        $this->sql = $sSql;
    }
}