<?php 

namespace App\DAO;

class ResultDAO extends DAO {
    
    /**
     * addResult
     * create in database a result with the result passed since router
     * @param  bool $result
     * @return void
     */
    public function addResult($result) {
        $req = 'INSERT INTO result(result) VALUES (?)';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$result]);
    }
    
    /**
     * getResults
     * fetch in database all results
     * @return void
     */
    public function getResults() {
        $req = 'SELECT * FROM result';
        $data = $this->createQuery($req);
        return $data;
    }
    
    /**
     * supprResults
     * delete in database all results saved 
     * @return void
     */
    public function supprResults() {
        $req = 'DELETE FROM result';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute();
    }
}