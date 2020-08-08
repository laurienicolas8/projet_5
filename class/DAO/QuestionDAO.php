<?php

namespace App\DAO;

class QuestionDAO extends DAO {
    
    /**
     * getQuizQuestions
     * fetch in database all questions of the quiz concerned by idQuiz
     * @param  int $idQuiz
     * @return array
     */
    public function getQuizQuestions($idQuiz) {
        $req = 'SELECT * FROM question WHERE idQuiz = ? ORDER BY RAND()';
        $data = $this->createQuery($req, [$idQuiz]);
        return $data;
    }
    
    /**
     * getSingleQuestion
     * fetch in database the question concerned by idQuestion
     * @param  int $idQuestion
     * @return array
     */
    public function getSingleQuestion($idQuestion) {
        $req = 'SELECT * FROM question WHERE idQuestion = ?';
        $data = $this->createQuery($req, [$idQuestion]);
        return $data;
    }
    
    /**
     * getCountQuizQuestions
     * count all questions in the quiz concerned by idQuiz
     * return the count
     * @param  int $idQuiz
     * @return array
     */
    public function getCountQuizQuestions($idQuiz) {
        $req = 'SELECT COUNT(*) FROM question WHERE idQuiz = ?';
        $data = $this->createQuery($req, [$idQuiz]);
        return $data;
    }
    
    /**
     * createQuestion
     * create in database a question with all parameters passed since router
     * @param  string $question
     * @param  string $explanation
     * @param  int $idQuiz
     * @return void
     */
    public function createQuestion($question, $explanation, $idQuiz) {
        $req = 'INSERT INTO question(question, explanation, idQuiz) VALUES (?, ?, ?)';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$question, $explanation, $idQuiz]);
    }
    
    /**
     * modifyQuestion
     * update in database the question concerned by idQuestion with all parameters passed since router
     * @param  int $idQuestion
     * @param  string $question
     * @param  string $explanation
     * @return void
     */
    public function modifyQuestion($idQuestion, $question, $explanation) {
        $req = 'UPDATE question SET question = ?, explanation = ? WHERE idQuestion = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$question, $explanation, $idQuestion]);
    }
    
    /**
     * supprQuestion
     * delete in database the question concerned by idQuestion
     * @param  int $idQuestion
     * @return void
     */
    public function supprQuestion($idQuestion) {
        $req = 'DELETE FROM question WHERE idQuestion = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$idQuestion]);
    }
}