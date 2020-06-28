<?php 
namespace projet_5\AnswerDAO;

require('./vendor/autoload.php');
use projet_5\Answer;


class AnswerDAO extends DAO {

    public function __construct() {
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