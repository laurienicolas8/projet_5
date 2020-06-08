<?php

class QuizDAO extends DAO {

    protected $quiz;

    public function __construct() {
        require('./model/Quiz.php');
        $this->quiz = new Quiz;
    }

    public function getAllQuiz() {

    }

    public function getSingleQuiz($idQuiz) {

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