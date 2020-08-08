<?php 

namespace App\DAO;

class AnswerDAO extends DAO {
    
    /**
     * getSingleAnswer
     * fetch in database the answer concerned by the idAnswer
     * @param  int $idAnswer
     * @return array
     */
    public function getSingleAnswer($idAnswer) {
        $req = 'SELECT * FROM answer WHERE idAnswer = ?';
        $data = $this->createQuery($req, [$idAnswer]);
        return $data;
    }
    
    /**
     * getQuestionAnswers
     * fetch in database the answers of the question concerned by the idQuestion
     * @param  int $idQuestion
     * @return array
     */
    public function getQuestionAnswers($idQuestion) {
        $req = 'SELECT * FROM answer WHERE idQuestion = ?';
        $data = $this->createQuery($req, [$idQuestion]);
        return $data;
    }
    
    /**
     * getRightAnswer
     * fetch in database the right answer of the question concerned by the idQuestion
     * @param  int $idQuestion
     * @return array
     */
    public function getRightAnswer($idQuestion) {
        $req = 'SELECT * FROM answer WHERE idQuestion = ? AND rightAnswer = 1';
        $data = $this->createQuery($req, [$idQuestion]);
        return $data;
    }
    
    /**
     * createAnswer
     * create in database a new answer with all parameters passed since router
     * @param  string $answer
     * @param  bool $rightAnswer
     * @param  int $idQuestion
     * @return void
     */
    public function createAnswer($answer, $rightAnswer, $idQuestion) {
        $req = 'INSERT INTO answer(answer, rightAnswer, idQuestion) VALUES (?, ?, ?)';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$answer, $rightAnswer, $idQuestion]);
    }
    
    /**
     * modifyAnswer
     * update in database the answer concerned by idAnswer with all parameters passed since router
     * @param  int $idAnswer
     * @param  string $answer
     * @param  bool $rightAnswer
     * @return void
     */
    public function modifyAnswer($idAnswer, $answer, $rightAnswer) {
        $req = 'UPDATE answer SET answer = ?, rightAnswer = ? WHERE idAnswer = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$answer, $rightAnswer, $idAnswer]);
    }
    
    /**
     * supprAnswer
     * delete in database the answer concerned by idAnswer
     * @param  int $idAnswer
     * @return void
     */
    public function supprAnswer($idAnswer) {
        $req = 'DELETE FROM answer WHERE idAnswer = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$idAnswer]);
    }
}