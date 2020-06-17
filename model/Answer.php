<?php 

class Answer {

    private $_idAnswer;
    private $_answer;
    private $_rightAnswer;
    private $_idQuestion;

    
    //getters
    public function idAnswer() {
        return $this->_idAnswer;
    }

    public function answer() {
        return $this->_answer;
    }

    public function rightAnswer() {
        return $this->_rightAnswer;
    }

    public function idQuestion() {
        return $this->_idQuestion;
    }


    //setters
    public function setIdAnswer($idAnswer) {
        $idAnswer = (int) $idAnswer;
        if ($idAnswer > 0) {
            $this->_idAnswer = $idAnswer;
        }
    }

    public function setAnswer($answer) {
        if (is_string($answer)) {
            $this->_answer = $answer;
        }
    }

    public function setRightAnswer($rightAnswer) {
        $rightAnswer = (int) $rightAnswer;
        if ($rightAnswer === 0 || $rightAnswer === 1) {
            $this->_rightAnswer = $rightAnswer;
        }
    }

    public function setIdQuestion($idQuestion) {
        $idQuestion = (int) $idQuestion;
        if ($idQuestion > 0) {
            $this->_idQuestion = $idQuestion;
        }
    }

}