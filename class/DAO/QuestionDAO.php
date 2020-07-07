<?php
namespace App\DAO;

use App\Entity\Question;

require('vendor/autoload.php');


class QuestionDAO extends DAO {

    public function __construct() {
    
    }

    public function getQuizQuestions($idQuiz) {
        $req = 'SELECT * from question WHERE idQuiz = ?';
        $data = $this->createQuery($req, [$idQuiz]);
        $questions = new Question;
        $questions->hydrate($data);
        return $questions;
    }

    /*public function getSingleQuestion($idQuestion) {

    }*/

    public function createQuestion($question, $explanation, $idQuiz) {

    }

    public function modifyQuestion($idQuestion, $question, $explanation) {
        
    }
}