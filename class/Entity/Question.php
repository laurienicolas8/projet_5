<?php

namespace App\Entity;

class Question extends Entity {

    private $_idQuestion;
    private $_question;
    private $_explanation;
    private $_idQuiz;

    //getters
    public function idQuestion() {
        return $this->_idQuestion;
    }

    public function question() {
        return $this->_question;
    }

    public function explanation() {
        return $this->_explanation;
    }

    public function idQuiz() {
        return $this->_idQuiz;
    }


    //setters
    public function setIdQuestion($idQuestion) {
        $idQuestion = (int) $idQuestion;
        if ($idQuestion > 0) {
            $this->_idQuestion = $idQuestion;
        }
    }

    public function setQuestion($question) {
        if (is_string($question)) {
            $this->_question = $question;
        }
    }
    
    public function setExplanation($explanation) {
        if (is_string($explanation)) {
            $this->_explanation = $explanation;
        }
    }

    public function setIdQuiz($idQuiz) {
        $idQuiz = (int) $idQuiz;
        if ($idQuiz > 0) {
            $this->_idQuiz = $idQuiz;
        }
    }
}