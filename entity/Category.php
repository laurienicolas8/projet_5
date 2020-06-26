<?php

class Category {

    private $_idCategory;
    private $_nameCategory;
    private $_imageCategory;

    public function hydrate(array $data) {
        foreach ($donnees as $key => $value) {
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);
                
            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
            // On appelle le setter.
            $this->$method($value);
            }
        }
    }

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