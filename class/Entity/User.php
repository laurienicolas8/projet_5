<?php

namespace App\Entity;

class User extends Entity {

    private $_idUser;
    private $_identifiant;
    private $_password;
    private $_nameUser;
    private $_lastnameUser;
    private $_admin;

    //getters
    public function idUser() {
        return $this->_idUser;
    }

    public function identifiant() {
        return $this->_identifiant;
    }

    public function password() {
        return $this->_password;
    }

    public function nameUser() {
        return $this->_nameUser;
    }

    public function lastnameUser() {
        return $this->_lastnameUser;
    }

    public function admin() {
        return $this->_admin;
    }

    
    //setters
    public function setIdUser($idUser) {
        $idUser = (int) $idUser;
        if ($idUser > 0) {
            $this->_idUser = $idUser;
        }
    }

    public function setIdentifiant($identifiant) {
        if (is_string($identifiant)) {
            $this->_identifiant = $identifiant;
        }
    }

    public function setNameUser($nameUser) {
        if (is_string($nameUser)) {
            $this->_nameUser = $nameUser;
        }
    }

    public function setLastnameUser($lastnameUser) {
        if (is_string($lastnameUser)) {
            $this->_lastnameUser = $lastnameUser;
        }
    }

    public function setPassword($password) {
        if (is_string($password)) {
            $this->_password = $password;
        }
    }

    public function setAdmin($admin) {
        if ($admin == 1 || $admin == 0){
            $this->_admin = $admin;
        }
    }
} 