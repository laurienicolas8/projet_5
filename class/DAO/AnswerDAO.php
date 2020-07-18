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

    public function createAnswer($answer, $rightAnswer, $idQuestion) {
        $req = 'INSERT INTO answer(answer, rightAnswer, idQuestion) VALUES (?, ?, ?)';
        $data = $this->createQuery($req, [$answer, $rightAnswer, $idQuestion]);
        return $data;
    }

    public function modifyAnswer($idAnswer, $answer, $rightAnswer) {
        $req = 'UPDATE answer SET answer = ?, rightAnswer = ? WHERE idAnswer = ?';
        $data = $this->createQuery($req, [$answer, $rightAnswer, $idAnswer]);
        return $data;
    }

    public function supprAnswer($idAnswer) {
        $req = 'DELETE FROM answer WHERE idAnswer = ?';
        $data = $this->createQuery($req, [$idAnswer]);
        return $data;
    }
}