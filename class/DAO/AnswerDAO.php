<?php 
namespace projet_5\DAO\AnswerDAO;

require('./vendor/autoload.php');


class AnswerDAO extends DAO {

    public function __construct() {
    }
    
    public function getQuestionAnswers($idQuestion) {
    
    }

    public function getRightAnswer($idQuestion) {
        $req = 'SELECT rightAnswer from answer WHERE idQuestion = ?';
        $data = $this->createQuery($req, [$idQuestion]);
        $rightAnswer = new Answer;
        $rightAnswer->hydrate($data);
        return $rightAnswer;
    }

    public function createAnswer($answer, $rightAnswer, $idQuestion) {

    }

    public function modifyAnswer($idAnswer, $answer, $rightAnswer) {

    }
}