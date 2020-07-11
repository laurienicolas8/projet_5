<?php

use App\Controller\BackController;
use App\Controller\FrontController;

require('vendor/autoload.php');

$router = new Router;
$router->run();


class Router {

    public $router;
    public $frontController;
    public $backController;

    public function run() {
        $this->router = new AltoRouter();
        $this->router->setBasePath('/projet_5');

        $this->frontController = new FrontController;
        $this->backController = new BackController;


        // Itinéraires
        $this->router->addRoutes(array(
            // FRONT
            array('GET', '/', function() {
                $this->frontController->home();
            }, 'home'),
            array('GET', '/all-quiz', function() {
                $this->frontController->allQuiz();
            }, 'all-quiz'),
            array('GET', '/single-category-[i:id]', function($idCategory) {
                $this->frontController->singleCategory($idCategory);
            }, 'single-category'),
            array('GET', '/start-quiz-[i:id]', function($idQuiz) {
                $this->frontController->startQuiz($idQuiz);
            }, 'start-quiz'),
            array('GET', '/quiz-[i:id]', function($idQuiz) {
                $this->frontController->showQuizQuestions($idQuiz);
            }, 'quiz'),
            //BACK
            
        ));

        // Trouver une correspondance entre l'URL reçue et les itinéraires
        $match = $this->router->match();

        if ($match !==null) {
            if (is_callable($match['target'])) {
                call_user_func_array($match['target'], $match['params']);
            } 
        }
    }
}