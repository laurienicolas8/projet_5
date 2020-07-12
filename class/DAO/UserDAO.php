<?php 
namespace App\DAO;

use App\Entity\User;

require('vendor/autoload.php');


class UserDAO extends DAO {
    
    public function getSingleUser($idUser) {
        $req = 'SELECT * from user WHERE idUser = ?';
        $data = $this->createQuery($req, [$idUser]);
        return $data;
    }
    public function getAllUsers() {
        $req = 'SELECT * from user';
        $data = $this->createQuery($req);
        return $data;
    }

    public function createUser($nameUser, $password, $admin) {

    }

    public function modifyUser($nameUser, $password, $admin) {

    }

    public function supprUser($idUser) {
        
    }
}