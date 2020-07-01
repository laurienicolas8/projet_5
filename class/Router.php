<?php
namespace App;

use App\Controller\BackController;
use App\Controller\FrontController;

require('../vendor/autoload.php');

class Router {
    public $router;
    public $frontController;
    public $backController;

    public function __construct() {
        $this->router = new \AltoRouter();
        $this->frontController = new FrontController();
        $this->backController = new BackController();
    }

    public function run() {
        // Itinéraires
        // FRONT
        $this->router->map('GET', '/', $this->frontController->home());
        $this->router->map('GET', '/all-categories', $this->frontController->allCategories());
        $this->router->map('GET', '/all-quiz', $this->frontController->allQuiz());
        $this->router->map('GET', '/category/[i:id]', $this->frontController->singleCategory($idCategory)); //param
        $this->router->map('GET', '/start-quiz/[i:id]', $this->frontController->startQuiz($idQuiz)); //param
        $this->router->map('GET', '/quiz/[i:id]', $this->frontController->showQuizQuestions($idQuiz)); //param

        //BACK


        // Trouver une correspondance entre l'URL reçue et les itinéraires
        $match = $router->match();

        if ($match !==null) {
            
        }
    }
}