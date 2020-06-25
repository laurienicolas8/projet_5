<?php

class User {

    private $_idUser;
    private $_nameUser;
    private $_password;
    private $_admin;

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
    public function idUser() {
        return $this->_idUser;
    }

    public function nameUser() {
        return $this->_idUser;
    }

    public function password() {
        return $this->_idUser;
    }

    public function admin() {
        return $this->_idUser;
    }


    //setters
    public function setIdUser($idUser) {
        $idQuiz = (int) $idQuiz;
        if ($idQuiz > 0) {
            $this->_idQuiz = $idQuiz;
        }
    }

    public function setNameUser($nameUser) {
        if (is_string($nameUser)) {
            $this->_nameUser = $nameUser;
        }
    }

    public function setPassword($password) {
        if (is_string($password)) {
            $this->_password = $password;
        }
    }

    public function setAdmin($admin) {
        if (is_string($admin)) {
            $this->_admin = $admin;
        }
    }
} 