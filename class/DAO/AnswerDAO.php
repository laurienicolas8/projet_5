<?php 
namespace App\DAO;

use App\Entity\Answer;

require('vendor/autoload.php');

class AnswerDAO extends DAO {

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