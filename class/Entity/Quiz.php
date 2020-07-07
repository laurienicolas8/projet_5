<?php 
namespace App\Entity;

class Quiz {

    private $_idQuiz;
    private $_nameQuiz;
    private $_imageQuiz;
    private $_idCategory;

    public function hydrate(array $data) {
        foreach ($donnees as $key => $value) {
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);
                
            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
            // On appelle le setter.
            $this->$method($value);
            }
        }
    }

    //getters
    public function idQuiz() {
        return $this->_idQuiz;
    }

    public function nameQuiz() {
        return $this->_nameQuiz;
    }

    public function imageQuiz() {
        return $this->_imageQuiz;
    }

    public function idCategory() {
        return $this->_idCategory;
    }


    //setters
    public function setIdQuiz($idQuiz) {
        $idQuiz = (int) $idQuiz;
        if ($idQuiz > 0) {
            $this->_idQuiz = $idQuiz;
        }
    }

    public function setNameQuiz($nameQuiz) {
        if (is_string($nameQuiz)) {
            $this->_nameQuiz = $nameQuiz;
        }
    }

    public function setImageQuiz($imageQuiz) {
        if (is_string($imageQuiz)) {
            $this->_imageQuiz = $imageQuiz;
        }
    }

    public function setIdCategory($idCategory) {
        $idCategory = (int) $idCategory;
        if ($idCategory > 0) {
            $this->_idCategory = $idCategory;
        }
    }
}