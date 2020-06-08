<?php

class QuestionDAO extends DAO {

    protected $question;

    public function __construct() {
        require('./model/Question.php');
        $this->question = new Question;
    }

    public function getQuizQuestions($idQuiz) {

    }

    public function getSingleQuestion($idQuestion) {

    }

    public function createQuestion($question, $idQuiz, $idLevel) {

    }

    public function modifyQuestion($idQuestion, $question) {
        
    }
}