<?php
namespace App\DAO;

use App\Entity\Quiz;

require('vendor/autoload.php');


class QuizDAO extends DAO {

    public $quizPerPage;
    public $nbPages;

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

    public function getSingleQuiz($idQuiz) {
        $req = 'SELECT * FROM quiz WHERE idQuiz = ?';   
        $data = $this->createQuery($req, [$idQuiz]);
        return $data;
    }

    public function getHomeQuiz() {
        $req = 'SELECT * FROM quiz ORDER BY RAND() LIMIT 8';
        $data = $this->createQuery($req);
        return $data;
    }

    public function getQuizByCategory($idCategory) {
        $req = 'SELECT * FROM quiz WHERE idCategory = ?';
        $data = $this->createQuery($req, [$idCategory]);
        return $data;
    }

    public function createQuiz($nameQuiz, $imageQuiz, $idCategory) {
        $req = 'INSERT INTO quiz(nameQuiz, imageQuiz, idCategory) VALUES (?, ?, ?)';
        $data = $this->createQuery($req, [$nameQuiz, $imageQuiz, $idCategory]);
        return $data;
    }

    public function modifyQuiz($idQuiz, $nameQuiz, $imageQuiz, $idCategory) {
        $req = 'UPDATE quiz SET nameQuiz = ?, imageQuiz = ? WHERE idCategory = ?';
        $data = $this->createQuery($req, [$nameQuiz, $imageQuiz, $idCategory]);
        return $data;
    }

    public function supprQuiz($idQuiz) {
        $req = 'DELETE FROM quiz WHERE idQuiz = ?';
        $data = $this->createQuery($req, [$idQuiz]);
        return $data;
    }
}