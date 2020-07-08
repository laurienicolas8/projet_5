<?php
namespace App\Entity;

class User extends Entity {

    private $_idUser;
    private $_nameUser;
    private $_password;
    private $_admin;

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