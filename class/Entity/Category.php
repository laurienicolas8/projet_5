<?php
namespace App\Entity;

class Category extends Entity {

    private $_idCategory;
    private $_nameCategory;
    private $_imageCategory;

    //getters
    public function idCategory() {
        return $this->_idCategory;
    }

    public function nameCategory() {
        return $this->_nameCategory;
    }

    public function imageCategory() {
        return $this->_imageCategory;
    }


    //setters
    public function setIdCategory($idCategory) {
        $idCategory = (int) $idCategory;
        if ($idCategory > 0) {
            $this->_idCategory = $idCategory;
        }
    }
    
    public function setNameCategory($nameCategory) {
        if (is_string($nameCategory)) {
            $this->_nameCategory = $nameCategory;
        }
    }

    public function setImageCategory($imageCategory) {
        if (is_string($imageCategory)) {
            $this->_imageCategory = $imageCategory;
        }
    }
}