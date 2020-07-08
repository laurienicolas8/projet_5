<?php
namespace App\DAO;

use App\Entity\Quiz;

require('vendor/autoload.php');


class QuizDAO extends DAO {

    public function getAllQuiz() {
        $req = 'SELECT * FROM quiz';
        $data = $this->createQuery($req);
        return $data;
    }

    public function getSingleQuiz($idQuiz) {
        $req = 'SELECT * FROM quiz WHERE idQuiz = ?';   
        $data = $this->createQuery($req, [$idQuiz]);
        $quiz = new Quiz($data);
        return $quiz;
    }

    public function getSliderQuiz() {  
        $req = 'SELECT * FROM quiz ORDER BY RAND() LIMIT 3';
        $data = $this->createQuery($req);
        return $data;
    }

    public function getHomeQuiz() {
        $req = 'SELECT * FROM quiz ORDER BY RAND() LIMIT 9';
        $data = $this->createQuery($req);
        return $data;
    }

    public function getQuizByCategory($idCategory) {
        $req = 'SELECT * FROM quiz WHERE idCategory = ?';
        $data = $this->createQuery($req, [$idCategory]);
        return $data;
    }

    public function createQuiz($nameQuiz, $imageQuiz, $idCategory) {

    }

    public function modifyQuiz($idQuiz, $nameQuiz, $imageQuiz, $idCategory) {
        
    }

    public function supprQuiz($idQuiz) {
        
    }
}