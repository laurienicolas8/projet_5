<?php
namespace App;

use App\Controller\BackController;
use App\Controller\FrontController;

require('vendor/autoload.php');

class Router {

    public $router;
    public $frontController;
    public $backController;

    public function run() {
        $this->router = new \AltoRouter();
        $this->router->setBasePath('/projet_5');

        $this->frontController = new FrontController;
        $this->backController = new BackController;


        // Itinéraires
        $this->router->addRoutes(array(
            // FRONT
            array('GET', '/', function() {
                $this->frontController->home();
            }),
            array('GET', '/all_quiz', function() {
                $this->frontController->allQuiz();
            }),
            array('GET', '/single_category/[i:id]', function() {
                $this->frontController->singleCategory($id);
            }),
            array('GET', '/start_quiz/[i:id]', function() {
                $this->frontController->startQuiz($id);
            }),
            array('GET', '/quiz/[i:id]', function() {
                $this->frontController->showQuizQuestions($id);
            }),
            //BACK
        ));

        // Trouver une correspondance entre l'URL reçue et les itinéraires
        $match = $this->router->match();
        dump($match);

        if ($match !==null) {
            if (is_callable($match['target'])) {
                call_user_func_array($match['target'], $match['params']);
            } 
        }
    }
}