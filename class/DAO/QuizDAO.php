<?php
namespace App\DAO;

require('vendor/autoload.php');


class QuizDAO extends DAO {

    public function __construct() {

    }

    public function getAllQuiz() {

    }

    public function getSingleQuiz($idQuiz) {
        $req = 'SELECT * from quiz WHERE idQuiz = ?';
        $data = $this->createQuery($req, [$idQuiz]);
        $quiz = new Quiz;
        $quiz->hydrate($data);
        return $quiz;
    }

    public function getSliderQuiz() {

    }

    public function getHomeQuiz() {
        
    }

    public function getQuizByCategory($idCategory) {

    }

    public function createQuiz($nameQuiz, $imageQuiz, $idCategory) {

    }

    public function modifyQuiz($idQuiz, $nameQuiz, $imageQuiz, $idCategory) {
        
    }

    public function supprQuiz($idQuiz) {
        
    }
}