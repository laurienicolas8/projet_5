<?php
namespace App\DAO;

use App\Entity\Question;

require('vendor/autoload.php');


class QuestionDAO extends DAO {

    public function getQuizQuestions($idQuiz) {
        $req = 'SELECT * FROM question WHERE idQuiz = ?';
        $data = $this->createQuery($req, [$idQuiz]);
        return $data;
    }

    public function getSingleQuestion($idQuestion) {
        $req = 'SELECT * FROM question WHERE idQuestion = ?';
        $data = $this->createQuery($req, [$idQuestion]);
        return $data;
    }

    public function getCountQuestions() {
        $req = 'SELECT COUNT(*) FROM question';
        $data = $this->createQuery($req);
        return $data;
    }

    public function getCountQuizQuestions($idQuiz) {
        $req = 'SELECT COUNT(*) FROM question WHERE idQuiz = ?';
        $data = $this->createQuery($req, [$idQuiz]);
        return $data;
    }

    public function createQuestion($question, $explanation, $idQuiz) {
        $req = 'INSERT INTO question(question, explanation, idQuiz) VALUES (?, ?, ?)';
        $data = $this->createQuery($req, [$question, $explanation, $idQuiz]);
        return $data;
    }

    public function modifyQuestion($idQuestion, $question, $explanation) {
        $req = 'UPDATE question SET question = ?, explanation = ? WHERE idQuestion = ?';
        $data = $this->createQuery($req, [$question, $explanation, $idQuestion]);
        return $data;
    }

    public function  supprQuestion($idQuestion) {
        $req = 'DELETE FROM question WHERE idQuestion = ?';
        $data = $this->createQuery($req, [$idQuestion]);
        return $data;
    }
}