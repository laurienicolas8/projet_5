<?php 

namespace App\DAO;

class UserDAO extends DAO {
    
    public function getSingleUser($idUser) {
        $req = 'SELECT * FROM user WHERE idUser = ?';
        $data = $this->createQuery($req, [$idUser]);
        return $data;
    }
    
    public function getAllUsers() {
        $req = 'SELECT * FROM user';
        $data = $this->createQuery($req);
        return $data;
    }

    public function getUserByIdentifiant($identifiant) {
        $req = 'SELECT * FROM user WHERE identifiant = ?';
        $data = $this->createQuery($req, [$identifiant]);
        return $data;
    }

    public function getPasswordByIdentifiant($identifiant) {
        $req = 'SELECT password FROM user WHERE identifiant = ?';
        $data = $this->createQuery($req, [$identifiant]);
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