<?php

class CategoryDAO extends DAO {

    protected $category;

    public function __construct() {
        require('./model/Category.php');
        //$this->category = new Category;
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