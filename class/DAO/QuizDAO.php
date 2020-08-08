<?php

namespace App\DAO;

class QuizDAO extends DAO {

    public $quizPerPage;
    public $nbPages;
    
    /**
     * getAllQuiz
     * count all quiz
     * calculating quiz per page and number of pages
     * fetch in database the number of quiz per page
     * @param  int $currentPage
     * @return array
     */
    public function getAllQuiz($currentPage) {
        $req1 = 'SELECT COUNT(idQuiz) as nbQuiz FROM quiz';
        $data1 = $this->createQuery($req1);
        foreach ($data1 as $countQuiz) {
            $nbQuiz = $countQuiz['nbQuiz'];
        }
        $this->quizPerPage = 19;
        $this->nbPages = ceil($nbQuiz/$this->quizPerPage);

        $req2 = 'SELECT * FROM quiz ORDER BY RAND() LIMIT '.(($currentPage-1)*$this->quizPerPage).', '.$this->quizPerPage.'';
        $data2 = $this->createQuery($req2);
        return $data2;
    }
    
    /**
     * getSingleQuiz
     * fetch in database the quiz concerned by idQuiz
     * @param  int $idQuiz
     * @return array
     */
    public function getSingleQuiz($idQuiz) {
        $req = 'SELECT * FROM quiz WHERE idQuiz = ?';   
        $data = $this->createQuery($req, [$idQuiz]);
        return $data;
    }
    
    /**
     * getHomeQuiz
     * fetch in database only 8 quiz for the home page
     * @return array
     */
    public function getHomeQuiz() {
        $req = 'SELECT * FROM quiz ORDER BY RAND() LIMIT 8';
        $data = $this->createQuery($req);
        return $data;
    }
    
    /**
     * getQuizByCategory
     * fetch in database all quiz of the category concerned by idCategory
     * @param  int $idCategory
     * @return array
     */
    public function getQuizByCategory($idCategory) {
        $req = 'SELECT * FROM quiz WHERE idCategory = ?';
        $data = $this->createQuery($req, [$idCategory]);
        return $data;
    }
    
    /**
     * createQuiz
     * create in database a new quiz with all parameters passed since router
     * @param  string $nameQuiz
     * @param  string $imageQuiz
     * @param  int $idCategory
     * @return void
     */
    public function createQuiz($nameQuiz, $imageQuiz, $idCategory) {
        $req = 'INSERT INTO quiz(nameQuiz, imageQuiz, idCategory) VALUES (?, ?, ?)';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$nameQuiz, $imageQuiz, $idCategory]);
    }
    
    /**
     * modifyQuiz
     * update in database the quiz concerned by idQuiz with all parameters passed since router
     * @param  int $idQuiz
     * @param  string $nameQuiz
     * @param  string $imageQuiz
     * @param  int $idCategory
     * @return void
     */
    public function modifyQuiz($idQuiz, $nameQuiz, $imageQuiz, $idCategory) {
        $req = 'UPDATE quiz SET nameQuiz = ?, imageQuiz = ?, idCategory = ? WHERE idQuiz = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$nameQuiz, $imageQuiz, $idCategory, $idQuiz]);
    }
    
    /**
     * supprQuiz
     * delete in database the quiz concerned by idQuiz
     * @param  int $idQuiz
     * @return void
     */
    public function supprQuiz($idQuiz) {
        $req = 'DELETE FROM quiz WHERE idQuiz = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$idQuiz]);
    }
}