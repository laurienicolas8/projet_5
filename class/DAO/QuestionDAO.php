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

    /*public function getSingleQuestion($idQuestion) {

    }*/

    public function createQuestion($question, $explanation, $idQuiz) {

    }

    public function modifyQuestion($idQuestion, $question, $explanation) {
        
    }
}