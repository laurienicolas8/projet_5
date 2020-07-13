<?php 
namespace App\DAO;

use App\Entity\Answer;

require('vendor/autoload.php');

class AnswerDAO extends DAO {

    public function getQuestionAnswers($idQuestion) {
        $req = 'SELECT * from answer WHERE idQuestion = ? ORDER BY RAND()';
        $data = $this->createQuery($req, [$idQuestion]);
        return $data;
    }

    public function getRightAnswer($idQuestion) {
        $req = 'SELECT rightAnswer from answer WHERE idQuestion = ?';
        $data = $this->createQuery($req, [$idQuestion]);
        $rightAnswer = new Answer($data);
        return $rightAnswer;
    }

    public function createAnswer($answer, $rightAnswer, $idQuestion) {

    }

    public function modifyAnswer($idAnswer, $answer, $rightAnswer) {

    }
}