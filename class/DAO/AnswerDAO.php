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
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$answer, $rightAnswer, $idQuestion]);
    }

    public function modifyAnswer($idAnswer, $answer, $rightAnswer) {
        $req = 'UPDATE answer SET answer = ?, rightAnswer = ? WHERE idAnswer = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$answer, $rightAnswer, $idQuestion]);
    }

    public function supprAnswer($idAnswer) {
        $req = 'DELETE FROM answer WHERE idAnswer = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$idAnswer]);
    }
}