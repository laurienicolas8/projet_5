<?php
namespace projet_5\CategoryDAO;

require('./vendor/autoload.php');
use projet_5\Category;


class CategoryDAO extends DAO {

    public function __construct() {
        
    }

    public function getAllCategories() {
        
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