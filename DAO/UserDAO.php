<?php 

class UserDAO extends DAO {

    protected $user;

    public function __construct() {
        require('./model/User.php');
        $this->user = new User;
    }

    public function getUser($idUser) {

    }

    public function createUser($nameUser, $password, $admin) {

    }

    public function modifyUser($nameUser, $password, $admin) {

    }

    public function supprUser($idUser) {
        
    }
}