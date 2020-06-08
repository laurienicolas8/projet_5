<?php

class LevelDAO extends DAO {

    protected $level;

    public function __construct() {
        require('./model/Level.php');
        $this->level = new Level;
    }

    public function getAllLevels() {

    }
    
    public function createLevel($nameLevel, $colorLevel) {

    }

    public function modifyLevel($idLevel, $nameLevel, $colorLevel) {

    }

    public function supprLevel($idLevel) {
        
    }
}