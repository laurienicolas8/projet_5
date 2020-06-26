<?php
namespace projet_5\Question;

class Question {

    private $_idQuestion;
    private $_question;
    private $_explanation;
    private $_idQuiz;

    public function hydrate(array $data) {
        foreach ($donnees as $key => $value) {
            // on récupère le nom du setter correspondant à l'attribut
            $method = 'set'.ucfirst($key);
                
            // si le setter correspondant existe
            if (method_exists($this, $method))
            {
            // On appelle le setter.
            $this->$method($value);
            }
        }
    }

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