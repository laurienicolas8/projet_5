<?php
namespace App\DAO;

use PDO;

class DAO {
    const DB_HOST = 'mysql:host=localhost;dbname=questionnary;port=3308';
    const DB_USER = 'root';
    const DB_PASS = '';
    private $connection; 
    
    
    protected function checkConnection() {
        if ($this->connection===null) {
            return $this->dbConnection();
        }
        return $this->connection;
    }

    private function dbConnection() {
        try {
            $this->connection = new PDO(self::DB_HOST, self::DB_USER, self::DB_PASS);
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
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            $result = $req->execute($parameters);
            return $result;
        }
        $req = $this->checkConnection()->query($sql);
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}