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
            array('GET', '/quiz-questions-[i:id]', function($idQuiz) {
                $this->frontController->showQuizQuestions($idQuiz);
            }, 'quiz-questions'),
            array('GET', '/login', function() {
                $this->frontController->login();
            }, 'login'),

            //BACK
            array('GET', '/dashboard', function() {
                $this->backController->dashboard();
            }, 'dashboard'),
            array('GET', '/categories', function() {
                $this->backController->categories();
            }, 'categories'),
            array('GET', '/new-category', function() {
                $this->backController->newCategory();
            }, 'new-category'),
            array('GET', '/edit-category-[i:id]', function($idCategory) {
                $this->backController->editCategory($idCategory);
            }, 'edit-category'),
            array('GET', '/alert-category-[i:id]', function($idCategory) {
                $this->backController->alertCategory($idCategory);
            }, 'alert-category'),
            array('GET', '/details-category-[i:id]', function($idCategory) {
                $this->backController->detailsCategory($idCategory);
            }, 'details-category'),
            array('GET', '/quiz', function() {
                $this->backController->quiz();
            }, 'quiz'),
            array('GET', '/new-quiz', function() {
                $this->backController->newQuiz();
            }, 'new-quiz'),
            array('GET', '/edit-quiz-[i:id]', function($idQuiz) {
                $this->backController->editQuiz($idQuiz);
            }, 'edit-quiz'),
            array('GET', '/alert-quiz-[i:id]', function($idQuiz) {
                $this->backController->alertQuiz($idQuiz);
            }, 'alert-quiz'),
            array('GET', '/details-quiz-[i:id]', function($idQuiz) {
                $this->backController->detailsQuiz($idQuiz);
            }, 'details-quiz'),
            array('GET', '/details-question-[i:id]', function($idQuestion) {
                $this->backController->detailsQuestion($idQuestion);
            }, 'details-question'),
            array('GET', '/users', function() {
                $this->backController->users();
            }, 'users'),
            array('GET', '/new-user', function() {
                $this->backController->newUser();
            }, 'new-user'),
            array('GET', '/edit-user-[i:id]', function($idUser) {
                $this->backController->editUser($idUser);
            }, 'edit-user'),
            array('GET', '/alert-user-[i:id]', function($idUser) {
                $this->backController->alertUser($idUser);
            }, 'alert-user'),
            array('GET', '/detais-user-[i:id]', function($idUser) {
                $this->backController->detailsUser($idUser);
            }, 'details-user'),
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