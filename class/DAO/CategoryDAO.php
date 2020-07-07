<?php
namespace App\DAO;

use App\Entity\Category;

require('vendor/autoload.php');


class CategoryDAO extends DAO {

    public function __construct() {
        
    }

    public function getAllCategories() {
        $req = 'SELECT * from category WHERE idCategory = 20';
        $data = $this->createQuery($req);
        $category = new Category;
        $category->hydrate($data);
        return $category;
    }

    public function getSingleCategory($idCategory) {
        $req = 'SELECT * from category WHERE idCategory = ?';
        $data = $this->createQuery($req, [$idCategory]);
        $category = new Category;
        $category->hydrate($data);
        return $category;
    }

    public function createCategory($nameCategory, $imageCategory) {

    }

    public function modifyCategory($idCategory, $nameCategory, $imageCategory) {

    }

    public function supprCategory($idCategory) {
        
    }
}