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
        $this->router->setBasePath('/questionnary');

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

            array('GET', '/single-category-[i:idCategory]', function($idCategory) {
                $this->frontController->detailSingleCategory($idCategory);
            }, 'single-category'),

            array('GET', '/start-quiz-[i:idQuiz]', function($idQuiz) {
                $this->frontController->startQuiz($idQuiz);
            }, 'start-quiz'),

            array('GET', '/first-question-[i:idQuestion]-[i:idQuiz]', function($idQuestion, $idQuiz) {
                $this->frontController->firstQuestion($idQuestion, $idQuiz);
            }, 'first-question'),

            array('GET', '/quiz-questions-[i:idQuiz]', function($idQuiz) {
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
            array('POST', '/valid-new-answer-[i:idQuestion]', function($idQuestion) {
                $this->backController->validNewAnswer($_POST['answer'], $_POST['rightAnswer'], $idQuestion);
                $this->backController->detailsQuestion($idQuestion);
            }, 'valid-new-answer'),

            array('GET', '/edit-answer-[i:idAnswer]-[i:idQuestion]', function($idAnswer, $idQuestion) {
                $this->backController->editAnswer($idAnswer, $idQuestion);
            }, 'edit-answer'),

            array('POST', '/update-answer-[i:idAnswer]-[i:idQuestion]', function($idAnswer, $idQuestion) {
                $this->backController->updateAnswer($idAnswer, $_POST['answer'], $_POST['rightAnswer']);
                $this->backController->detailsQuestion($idQuestion);
            }, 'update-answer'),

            array('GET', '/delete-answer-[i:idAnswer]-[i:idQuestion]', function($idAnswer, $idQuestion) {
                $this->backController->deleteAnswer($idAnswer);
                $this->backController->detailsQuestion($idQuestion);
            }, 'delete-answer'),

            //---------- Categories ----------//
            array('GET', '/categories', function() {
                $this->backController->categories();
            }, 'categories'),

            array('GET', '/details-category-[i:idCategory]', function($idCategory) {
                $this->backController->detailsCategory($idCategory);
            }, 'details-category'),

            array('GET', '/new-category', function() {
                $this->backController->newCategory();
            }, 'new-category'),

            array('POST', '/valid-new-category', function() {
                $this->backController->validNewCategory($_POST['nameCategory'], $_POST['imageCategory']);
                $this->backController->categories();           
            }, 'valid-new-category'),

            array('GET', '/edit-category-[i:idCategory]', function($idCategory) {
                $this->backController->editCategory($idCategory);
            }, 'edit-category'),

            array('POST', '/update-category-[i:idCategory]', function($idCategory) {
                $this->backController->updateCategory($idCategory, $_POST['nameCategory'], $_POST['imageCategory']);
                $this->backController->detailsCategory($idCategory);
            }, 'update-category'),

            array('GET', '/alert-category-[i:idCategory]', function($idCategory) {
                $this->backController->alertCategory($idCategory);
            }, 'alert-category'),

            array('GET', '/delete-category-[i:idCategory]', function($idCategory) {
                $this->backController->deleteCategory($idCategory);
                $this->backController->categories(); 
            }, 'delete-category'),

            //---------- Quiz ----------//
            array('GET', '/quiz-[i:currentPage]', function($currentPage) {
                $this->backController->quiz($currentPage);
            }, 'quiz'),

            array('GET', '/details-quiz-[i:idQuiz]', function($idQuiz) {
                $this->backController->detailsQuiz($idQuiz);
            }, 'details-quiz'),

            array('GET', '/new-quiz', function() {
                $this->backController->newQuiz();
            }, 'new-quiz'),

            array('POST', '/valid-new-quiz-[i:currentPage]', function($currentPage) {
                $this->backController->validNewQuiz($_POST['nameQuiz'], $_POST['imageQuiz'], $_POST['idCategory']);
                $this->backController->detailsCategory($_POST['idCategory']);
            }, 'valid-new-quiz'),

            array('GET', '/edit-quiz-[i:idQuiz]-[i:idCategory]', function($idQuiz, $idCategory) {
                $this->backController->editQuiz($idQuiz, $idCategory);
            }, 'edit-quiz'),

            array('POST', '/update-quiz-[i:idQuiz]', function($idQuiz) {
                $this->backController->updateQuiz($idQuiz, $_POST['nameQuiz'], $_POST['imageQuiz'], $_POST['idCategory']);
                $this->backController->detailsQuiz($idQuiz);
            }, 'update-quiz'),

            array('GET', '/alert-quiz-[i:idQuiz]', function($idQuiz) {
                $this->backController->alertQuiz($idQuiz);
            }, 'alert-quiz'),

            array('GET', '/delete-quiz-[i:idQuiz]-[i:idCategory]', function($idQuiz, $idCategory) {
                $this->backController->deleteQuiz($idQuiz);
                $this->backController->detailsCategory($idCategory);
            }, 'delete-quiz'),
            
            //---------- Question ----------//
            array('GET', '/details-question-[i:idQuestion]', function($idQuestion) {
                $this->backController->detailsQuestion($idQuestion);
            }, 'details-question'),

            array('GET', '/new-question-[i:idQuiz]', function($idQuiz) {
                $this->backController->newQuestion($idQuiz);
            }, 'new-question'),

            array('POST', '/valid-new-question-[i:idQuiz]', function($idQuiz) {
                $this->backController->validNewQuestion($_POST['question'], $_POST['explanation'], $idQuiz);
                $this->backController->detailsQuiz($idQuiz);
            }, 'valid-new-question'),

            array('GET', '/edit-question-[i:idQuestion]', function($idQuestion) {
                $this->backController->editQuestion($idQuestion);
            }, 'edit-question'),

            array('POST', '/update-question-[i:idQuestion]', function($idQuestion) {
                $this->backController->updateQuestion($idQuestion, $_POST['question'], $_POST['explanation']);
                $this->backController->detailsQuestion($idQuestion);
            }, 'update-question'),

            array('GET', '/alert-question-[i:idQuestion]', function($idQuestion) {
                $this->backController->alertQuestion($idQuestion);
            }, 'alert-question'),

            array('GET', '/delete-question-[i:idQuestion]-[i:idQuiz]', function($idQuestion, $idQuiz) {
                $this->backController->deleteQuestion($idQuestion);
                $this->backController->detailsQuiz($idQuiz);
            }, 'delete-question'),

            //---------- User ----------//
            array('GET', '/users', function() {
                $this->backController->users();
            }, 'users'),

            array('GET', '/details-user-[i:idUser]', function($idUser) {
                $this->backController->detailsUser($idUser);
            }, 'details-user'),

            array('GET', '/new-user', function() {
                $this->backController->newUser();
            }, 'new-user'),

            array('POST', '/valid-new-user', function() {
                $this->backController->validNewUser($_POST['identifiant'], $_POST['password'], $_POST['nameUser'], $_POST['lastnameUser'], $_POST['admin']);
                $this->backController->users();
            }, 'valid-new-user'),

            array('GET', '/edit-user-[i:idUser]', function($idUser) {
                $this->backController->editUser($idUser);
            }, 'edit-user'),

            array('POST', '/update-user-[i:idUser]', function($idUser) {
                $this->backController->updateUser($idUser, $_POST['identifiant'], $_POST['password'], $_POST['nameUser'], $_POST['lastnameUser'], $_POST['admin']);
                $this->backController->detailsUser($idUser);
            }, 'update-user'),

            array('GET', '/alert-user-[i:idUser]', function($idUser) {
                $this->backController->alertUser($idUser);
            }, 'alert-user'),
            
            array('GET', '/delete-user-[i:idUser]', function($idUser) {
                $this->backController->deleteUser($idUser);
                $this->backController->users();
            }, 'delete-user'),
        ));

        // Trouver une correspondance entre l'URL reçue et les itinéraires
        $match = $this->router->match();
        if ($match !==null) {
            if (is_callable($match['target'])) {
                call_user_func_array($match['target'], $match['params']);
            } else  {
                echo 'Erreur 404 : Page non trouvée';
            }
        }
    }
}