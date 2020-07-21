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

    public function createUser($identifiant, $password, $nameUser, $lastnameUser, $admin) {
        $req = 'INSERT INTO user(identifiant, password, nameUser, lastnameUser, admin) VALUES (?, ?, ?, ?, ?)';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$identifiant, $password, $nameUser, $lastnameUser, $admin]);
    }

    public function modifyUser($idUser, $identifiant, $password, $nameUser, $lastnameUser, $admin) {
        $req = 'UPDATE user SET identifiant = ?, password = ?, nameUser = ?, lastnameUser = ?, admin = ? WHERE idUser = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$identifiant, $password, $nameUser, $lastnameUser, $admin, $idUser]);
    }

    public function supprUser($idUser) {
        $req = 'DELETE FROM user WHERE idUser = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$idUser]);
    }
}