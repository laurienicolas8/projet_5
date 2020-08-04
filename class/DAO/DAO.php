<?php

namespace App\DAO;
use PDO;

require_once('config.php');

class DAO {

    private $connection; 
    
    protected function checkConnection() {
        if ($this->connection===null) {
            return $this->dbConnection();
        }
        return $this->connection;
    }

    private function dbConnection() {
        try {
            $this->connection = new PDO(DB_HOST, DB_USER, DB_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        }
        catch (Exception $errConnection) {
            die('Erreur de connection à la base de données :'.$errConnection->getMessage());
        }
    }
    
    protected function createQuery($sql, $parameters=null) {
        if ($parameters) {
            $req = $this->checkConnection()->prepare($sql);
            $result = $req->execute($parameters);
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        $req = $this->checkConnection()->query($sql);
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}