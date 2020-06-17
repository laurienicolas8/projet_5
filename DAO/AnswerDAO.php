<?php 

class AnswerDAO extends DAO {

    protected $answer;

    public function __construct() {
        require('./model/Answer.php');
        $this->answer = new Answer;
    }
    
    public function getQuestionAnswers($idQuestion) {

    }

    public function getRightAnswer($idQuestion) {

    }

    public function createAnswer($answer, $rightAnswer, $idQuestion) {

    }

    public function modifyAnswer($idAnswer, $answer, $rightAnswer) {

    }
}