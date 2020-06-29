<?php
namespace FrontController;

require('./vendor/autoload.php');

class FrontController extends Controller {
    
    public function home() {
        require('./view/frontend/home.php');
    }

}