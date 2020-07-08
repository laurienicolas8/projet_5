<?php 
namespace App\DAO;

use App\Entity\User;

require('vendor/autoload.php');


class UserDAO extends DAO {
    
    public function getUser($idUser) {
        $req = 'SELECT * from user WHERE idUser = ?';
        $data = $this->createQuery($req, [$idUser]);
        $user = new User;
        $user->hydrate($data);
        return $user;
    }

    public function createUser($nameUser, $password, $admin) {

    }

    public function modifyUser($nameUser, $password, $admin) {

    }

    public function supprUser($idUser) {
        
    }
}