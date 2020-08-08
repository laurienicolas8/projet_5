<?php

namespace App\DAO;

class CategoryDAO extends DAO {
    
    /**
     * getAllCategories
     * fetch in database all categories
     * @return array
     */
    public function getAllCategories() {
        $req = 'SELECT * FROM category';
        $data = $this->createQuery($req);
        return $data;
    }
    
    /**
     * getSingleCategory
     * fetch in database the category concerned by idCategory
     * @param  int $idCategory
     * @return array
     */
    public function getSingleCategory($idCategory) {
        $req = 'SELECT * FROM category WHERE idCategory = ?';
        $data = $this->createQuery($req, [$idCategory]);
        return $data;
    }
        
    /**
     * getCountCategories
     * count the number of categories in database and return the count
     * @return array
     */
    public function getCountCategories() {
        $req = 'SELECT COUNT(*) FROM category';
        $data = $this->createQuery($req);
        return $data;
    }
    
    /**
     * createCategory
     * create in database a category with all parameters passed since router
     * @param  string $nameCategory
     * @param  string $imageCategory
     * @return void
     */
    public function createCategory($nameCategory, $imageCategory) {
        $req = 'INSERT INTO category(nameCategory, imageCategory) VALUES (?, ?)';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$nameCategory, $imageCategory]);
    }
    
    /**
     * modifyCategory
     * update in database the category concerned by idCategory with all paramaters passed since router
     * @param  int $idCategory
     * @param  string $nameCategory
     * @param  string $imageCategory
     * @return void
     */
    public function modifyCategory($idCategory, $nameCategory, $imageCategory) {
        $req = 'UPDATE category SET nameCategory = ?, imageCategory = ? WHERE idCategory = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$nameCategory, $imageCategory, $idCategory]);
    }
    
    /**
     * supprCategory
     * delete in database the category concerned by idCategory
     * @param  int $idCategory
     * @return void
     */
    public function supprCategory($idCategory) {
        $req = 'DELETE FROM category WHERE idCategory = ?';
        $sql = $this->checkConnection()->prepare($req);
        $sql->execute([$idCategory]);
    }
}