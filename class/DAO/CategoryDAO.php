<?php
namespace App\DAO;

use PDO;
use App\Entity\Category;

require('vendor/autoload.php');


class CategoryDAO extends DAO {

    public function getAllCategories() {
        $req = 'SELECT * FROM category';
        $data = $this->createQuery($req);
        return $data;
    }

    public function getSingleCategory($idCategory) {
        $req = 'SELECT * FROM category WHERE idCategory = ?';
        $data = $this->createQuery($req, [$idCategory]);
        return $data;
    }
    
    public function getCountCategories() {
        $req = 'SELECT COUNT(*) FROM category';
        $data = $this->createQuery($req);
        return $data;
    }

    public function createCategory($nameCategory, $imageCategory) {
        $req = 'INSERT INTO category(nameCategory, imageCategory) VALUES (?, ?)';
        $data = $this->createQuery($req, [$nameCategory, $imageCategory]);
        return $data;
    }

    public function modifyCategory($idCategory, $nameCategory, $imageCategory) {
        $req = 'UPDATE category SET nameCategory = ?, imageCategory = ? WHERE idCategory = ?';
        $data = $this->createQuery($req, [$nameCategory, $imageCategory, $idCategory]);
        return $data;
    }

    public function supprCategory($idCategory) {
        $req = 'DELETE FROM category WHERE idCategory = ?';
        $data = $this->createQuery($req, [$idCategory]);
        return $data;
    }
}