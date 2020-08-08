<?php 

namespace App\DAO;

class UserDAO extends DAO {
        
    /**
     * getSingleUser
     * fetch in database the user concerned by idUser
     * @param  int $idUser
     * @return array
     */
    public function getSingleUser($idUser) {
        $req = 'SELECT * FROM user WHERE idUser = ?';
        $data = $this->createQuery($req, [$idUser]);
        return $data;
    }
        
    /**
     * getAllUsers
     * fetch in database all users
     * @return array
     */
    public function getAllUsers() {
        $req = 'SELECT * FROM user';
        $data = $this->createQuery($req);
        return $data;
    }
    
    /**
     * getUserByIdentifiant
     * fetch in database the user concerned by the identifiant passed in parameter
     * @param  string $identifiant
     * @return array
     */
    public function getUserByIdentifiant($identifiant) {
        $req = 'SELECT * FROM user WHERE identifiant = ?';
        $data = $this->createQuery($req, [$identifiant]);
        return $data;
    }
    
    /**
     * getPasswordByIdentifiant
     * fetch in database the password concerned by the identifiant passed in parameter
     * @param  string $identifiant
     * @return array
     */
    public function getPasswordByIdentifiant($identifiant) {
        $req = 'SELECT password FROM user WHERE identifiant = ?';
        $data = $this->createQuery($req, [$identifiant]);
        return $data;
    }
    
    /**
     * createUser
     * create in database a new user with all parameters passed since router
     * @param  string $identifiant
     * @param  string $password
     * @param  string $nameUser
     * @param  string $lastnameUser
     * @param  bool $admin
     * @return void
     */
    public function createUser($identifiant, $password, $nameUser, $lastnameUser, $admin) {
        $req = 'INSERT INTO user(identifiant, password, nameUser, lastnameUser, admin) VALUES (?, ?, ?, ?, ?)';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$identifiant, $password, $nameUser, $lastnameUser, $admin]);
    }
    
    /**
     * modifyUser
     * update in database the user concerned by idUser with all parameters passed since router
     * @param  int $idUser
     * @param  string $identifiant
     * @param  string $password
     * @param  string $nameUser
     * @param  string $lastnameUser
     * @param  bool $admin
     * @return void
     */
    public function modifyUser($idUser, $identifiant, $password, $nameUser, $lastnameUser, $admin) {
        $req = 'UPDATE user SET identifiant = ?, password = ?, nameUser = ?, lastnameUser = ?, admin = ? WHERE idUser = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$identifiant, $password, $nameUser, $lastnameUser, $admin, $idUser]);
    }
    
    /**
     * supprUser
     * delete in database the user concerned by idUser
     * @param  int $idUser
     * @return void
     */
    public function supprUser($idUser) {
        $req = 'DELETE FROM user WHERE idUser = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$idUser]);
    }
}