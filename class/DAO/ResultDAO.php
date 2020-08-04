<?php 

namespace App\DAO;

class ResultDAO extends DAO {

    public function addResult($result) {
        $req = 'INSERT INTO result(result) VALUES (?)';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$result]);
    }

    public function getResults() {
        $req = 'SELECT * FROM result';
        $data = $this->createQuery($req);
        return $data;
    }

    public function supprResults() {
        $req = 'DELETE FROM result';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute();
    }
}