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


        //---------- Routes ----------//
        $this->router->addRoutes(array(
            //---------- FRONT ----------//
            array('GET', '/', function() {
                $this->frontController->home();
            }, 'home'),

            array('GET', '/all-quiz-[i:currentPage]', function($currentPage) {
                $this->frontController->allQuiz($currentPage);
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

            //---------- BACK ----------//
            array('GET', '/dashboard', function() {
                $this->backController->dashboard();
            }, 'dashboard'),

            //---------- Answers ----------//
            array('POST', '/valid-new-answer-[a:answer]-[a:rightAnswer]-[i:idQuestion]', function($answer, $rightAnswer, $idQuestion) {
                $this->backController->validNewAnswer($answer, $rightAnswer, $idQuestion);
                $this->backController->detailsQuestion($idQuestion);
            }, 'valid-new-answer'),

            array('POST', '/update-answer-[i:idAnswer]-[a:answer]-[a:rightAnswer]-[i:idQuestion]', function($idAnswer, $answer, $rightAnswer, $idQuestion) {
                $this->backController->updateAnswer($idAnswer, $answer, $rightAnswer, $idQuestion);
                $this->backController->detailsQuestion($idQuestion);
            }, 'update-answer'),

            array('POST', '/delete-answer-[i:id]', function($idAnswer) {
                $this->backController->deleteAnswer($idAnswer);
                $this->backController->detailsQuestion($idQuestion);
            }, 'delete-answer'),

            //---------- Categories ----------//
            array('GET', '/categories', function() {
                $this->backController->categories();
            }, 'categories'),

            array('GET', '/details-category-[i:id]', function($idCategory) {
                $this->backController->detailsCategory($idCategory);
            }, 'details-category'),

            array('GET', '/new-category', function() {
                $this->backController->newCategory();
            }, 'new-category'),

            array('POST', '/valid-new-category-[a:nameCategory]-[a:imageCategory]', function($nameCategory, $imageCategory) {
                $this->backController->validNewCategory($nameCategory, $imageCategory);
                $this->backController->categories();                
            }, 'valid-new-category'),

            array('GET', '/edit-category-[i:id]', function($idCategory) {
                $this->backController->editCategory($idCategory);
            }, 'edit-category'),

            array('POST', '/update-category-[i:idCategory]-[a:nameCategory]-[a:imageCategory]', function($idCategory, $nameCategory, $imageCategory) {
                $this->backController->updateCategory($idCategory, $nameCategory, $imageCategory);
                $this->backController->detailsCategory($idCategory);
            }, 'update-category'),

            array('GET', '/alert-category-[i:id]', function($idCategory) {
                $this->backController->alertCategory($idCategory);
            }, 'alert-category'),

            array('POST', '/delete-category-[i:id]', function($idCategory) {
                $this->backController->deleteCategory($idCategory);
                $this->backController->categories(); 
            }, 'delete-category'),

            //---------- Quiz ----------//
            array('GET', '/quiz-[i:currentPage]', function($currentPage) {
                $this->backController->quiz($currentPage);
            }, 'quiz'),

            array('GET', '/details-quiz-[i:id]', function($idQuiz) {
                $this->backController->detailsQuiz($idQuiz);
            }, 'details-quiz'),

            array('GET', '/new-quiz', function() {
                $this->backController->newQuiz();
            }, 'new-quiz'),

            array('POST', '/valid-new-quiz-[a:nameQuiz]-[a:imageQuiz]-[i:idCategory]', function($nameQuiz, $imageQuiz, $idCategory) {
                $this->backController->validNewQuiz($nameQuiz, $imageQuiz, $idCategory);
                $this->backController->detailsCategory($idCategory);
            }, 'valid-new-quiz'),

            array('GET', '/edit-quiz-[i:id]', function($idQuiz) {
                $this->backController->editQuiz($idQuiz);
            }, 'edit-quiz'),

            array('POST', '/update-quiz-[i:idQuiz]-[a:nameQuiz]-[a:imageQuiz]-[i:idCategory]', function($idQuiz, $nameQuiz, $imageQuiz, $idCategory) {
                $this->backController->updateQuiz($idQuiz, $nameQuiz, $imageQuiz, $idCategory);
                $this->backController->detailsQuiz($idQuiz);
            }, 'update-quiz'),

            array('GET', '/alert-quiz-[i:id]', function($idQuiz) {
                $this->backController->alertQuiz($idQuiz);
            }, 'alert-quiz'),

            array('POST', '/delete-quiz-[i:id]', function($idQuiz) {
                $this->backController->deleteQuiz($idQuiz);
                $this->backController->quiz();
            }, 'delete-quiz'),
            
            //---------- Question ----------//
            array('GET', '/details-question-[i:id]', function($idQuestion) {
                $this->backController->detailsQuestion($idQuestion);
            }, 'details-question'),

            array('GET', '/new-question', function() {
                $this->backController->newQuestion();
            }, 'new-question'),

            array('POST', '/valid-new-question-[a:question]-[a:explanation]-[i:idQuiz]', function($question, $explanation, $idQuiz) {
                $this->backController->validNewQuestion($question, $explanation, $idQuiz);
                $this->backController->detailsQuiz($idQuiz);
            }, 'valid-new-question'),

            array('GET', '/edit-question-[i:id]', function($idQuestion) {
                $this->backController->editQuestion($idQuestion);
            }, 'edit-question'),

            array('POST', '/update-question-[i:idQuestion]-[a:question]-[a:explanation]-[i:idQuiz]', function($idQuestion, $question, $explanation, $idQuiz) {
                $this->backController->updateQuestion($idQuestion, $question, $explanation, $idQuiz);
                $this->backController->detailsQuestion($idQuestion);
            }, 'update-question'),

            array('GET', '/alert-question-[i:id]', function($idQuestion) {
                $this->backController->alertQuestion($idQuestion);
            }, 'alert-question'),

            array('POST', '/delete-question-[i:idQuestion]-[i:idQuiz]', function($idQuestion, $idQuiz) {
                $this->backController->deleteQuestion($idQuestion);
                $this->backController->detailsQuiz($idQuiz);
            }, 'delete-question'),

            //---------- User ----------//
            array('GET', '/users', function() {
                $this->backController->users();
            }, 'users'),

            array('GET', '/details-user-[i:id]', function($idUser) {
                $this->backController->detailsUser($idUser);
            }, 'details-user'),

            array('GET', '/new-user', function() {
                $this->backController->newUser();
            }, 'new-user'),

            array('POST', '/valid-new-user-[a:identifiant]-[a:password]-[a:nameUser]-[a:lastnameUser]-[a:admin]', function($identifiant, $password, $nameUser, $lastnameUser, $admin) {
                $this->backController->validNewUser($identifiant, $password, $nameUser, $lastnameUser, $admin);
                $this->backController->users();
            }, 'valid-new-user'),

            array('GET', '/edit-user-[i:id]', function($idUser) {
                $this->backController->editUser($idUser);
            }, 'edit-user'),

            array('POST', '/update-user-[i:idUser]-[a:identifiant]-[a:password]-[a:nameUser]-[a:lastnameUser]-[a:admin]', function($idUser, $identifiant, $password, $nameUser, $lastnameUser, $admin) {
                $this->backController->updateUser($idUser, $identifiant, $password, $nameUser, $lastnameUser, $admin);
                $this->backController->detailsUser($idUser);
            }, 'update-user'),

            array('GET', '/alert-user-[i:id]', function($idUser) {
                $this->backController->alertUser($idUser);
            }, 'alert-user'),
            
            array('POST', '/delete-user-[i:id]', function($idUser) {
                $this->backController->deleteUser($idUser);
                $this->backController->users();
            }, 'delete-user'),
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