<?php

namespace App\DAO;

class QuestionDAO extends DAO {

    public function getQuizQuestions($idQuiz) {
        $req = 'SELECT * FROM question WHERE idQuiz = ? ORDER BY RAND()';
        $data = $this->createQuery($req, [$idQuiz]);
        return $data;
    }

    public function getSingleQuestion($idQuestion) {
        $req = 'SELECT * FROM question WHERE idQuestion = ?';
        $data = $this->createQuery($req, [$idQuestion]);
        return $data;
    }

    public function getCountQuizQuestions($idQuiz) {
        $req = 'SELECT COUNT(*) FROM question WHERE idQuiz = ?';
        $data = $this->createQuery($req, [$idQuiz]);
        return $data;
    }

    public function createQuestion($question, $explanation, $idQuiz) {
        $req = 'INSERT INTO question(question, explanation, idQuiz) VALUES (?, ?, ?)';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$question, $explanation, $idQuiz]);
    }

    public function modifyQuestion($idQuestion, $question, $explanation) {
        $req = 'UPDATE question SET question = ?, explanation = ? WHERE idQuestion = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$question, $explanation, $idQuestion]);
    }

    public function supprQuestion($idQuestion) {
        $req = 'DELETE FROM question WHERE idQuestion = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$idQuestion]);
    }
}