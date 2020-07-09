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
        $category = new Category($data);
        return $category;
    }

    public function createCategory($nameCategory, $imageCategory) {

    }

    public function modifyCategory($idCategory, $nameCategory, $imageCategory) {

    }

    public function supprCategory($idCategory) {
        
    }
}