<?php
namespace DAO;

class DAO {
    const DB_HOST = 'mysql:host=localhost;dbname=book;port=3308';
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
            $result = $this->checkConnection()->prepare($sql);
            $result->setFetchMode(PDO::FETCH_CLASS, static::class);
            $result->execute($parameters);
            return $result;
        }
        $result = $this->checkConnection()->query($sql);
        $result->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $result;
    }
}