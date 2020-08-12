<?php 
namespace App\Router;

use App\Router\Request;
use App\Controller\BackController;
use App\Controller\FrontController;

require('vendor/autoload.php');

class Router {
    private $frontController;
    private $backController;
    private $request;

    public function __construct() {
        session_start();
        $this->frontController = new FrontController;
        $this->backController = new BackController;
        $this->request = new Request;
    }

    public function run() {    
        // Avoir the $_GET[] duplications parameters  
        $action = $this->request->reqGet()->getParam('action'); // $action = $_GET['action']
        $idCategory = $this->request->reqGet()->getParam('idCategory');
        $idQuiz = $this->request->reqGet()->getParam('idQuiz');
        $idQuestion = $this->request->reqGet()->getParam('idQuestion');
        $idAnswer = $this->request->reqGet()->getParam('idAnswer');
        $idUser = $this->request->reqGet()->getParam('idUser');
        $indexQuestion = $this->request->reqGet()->getParam('indexQuestion');
        $currentPage = $this->request->reqGet()->getParam('currentPage');

        try {
            if (isset($action)) {
                switch ($action) {
                    //---------- FRONT ----------//
                    case 'home':
                        $this->frontController->home(); 
                    break;
                    
                    case 'all-quiz':
                        $this->frontController->allQuiz($currentPage);
                    break;

                    case 'single-category':
                        $this->frontController->detailSingleCategory($idCategory);
                    break;

                    // Quiz system
                    case 'start-quiz':
                        $this->frontController->startQuiz($idQuiz);
                    break;

                    case 'question':
                        $this->frontController->question($indexQuestion, $idQuiz);
                    break;

                    case 'question-answer':
                        $this->frontController->checkAnswer($_POST['answer'], $idQuestion);
                        $this->frontController->answer($_POST['answer'], $indexQuestion, $idQuiz);
                        unset($_SESSION['right_answer']);
                        unset($_SESSION['wrong_answer']);
                    break;

                    case 'result':
                        $this->frontController->result($idQuiz);
                    break;

                    // Login system
                    case 'loginPage':
                        $this->frontController->loginPage();
                    break;

                    case 'login':
                        $this->frontController->login($_POST['identifiant'], $_POST['password']);
                    break;

                    case 'logout':
                        $this->frontController->logout();
                        $this->frontController->home();
                    break;

                    //---------- BACK ----------//
                    case 'dashboard':
                        $this->backController->dashboard();
                    break;

                    // Answers
                    case 'valid-new-answer':
                        $this->backController->validNewAnswer($_POST['answer'], $_POST['rightAnswer'], $idQuestion);
                        $this->backController->detailsQuestion($idQuestion);
                    break;

                    case 'edit-answer':
                        $this->backController->editAnswer($idAnswer, $idQuestion);
                    break;

                    case 'update-answer':
                        $this->backController->updateAnswer($idAnswer, $_POST['answer'], $_POST['rightAnswer']);
                        $this->backController->detailsQuestion($idQuestion);
                    break;

                    case 'delete-answer':
                        $this->backController->deleteAnswer($idAnswer);
                        $this->backController->detailsQuestion($idQuestion);
                    break;

                    // Categories
                    case 'categories':
                        $this->backController->categories();
                    break;

                    case 'details-category':
                        $this->backController->detailsCategory($idCategory);
                    break;

                    case 'new-category':
                        $this->backController->newCategory();
                    break;

                    case 'valid-new-category':
                        $this->backController->validNewCategory($_POST['nameCategory'], $_POST['imageCategory']);
                        $this->backController->categories();
                    break;

                    case 'edit-category':
                        $this->backController->editCategory($idCategory);
                    break;

                    case 'update-category':
                        $this->backController->updateCategory($idCategory, $_POST['nameCategory'], $_POST['imageCategory']);
                        $this->backController->detailsCategory($idCategory);
                    break;

                    case 'alert-category':
                        $this->backController->alertCategory($idCategory);
                    break;

                    case 'delete-category':
                        $this->backController->deleteCategory($idCategory);
                        $this->backController->categories();
                    break;

                    // Quiz
                    case 'quiz':
                        $this->backController->quiz($currentPage);
                    break;

                    case 'details-quiz':
                        $this->backController->detailsQuiz($idQuiz);
                    break;

                    case 'new-quiz':
                        $this->backController->newQuiz();
                    break;

                    case 'valid-new-quiz':
                        $this->backController->validNewQuiz($_POST['nameQuiz'], $_POST['imageQuiz'], $_POST['idCategory']);
                        $this->backController->detailsCategory($_POST['idCategory']);
                    break;

                    case 'edit-quiz':
                        $this->backController->editQuiz($idQuiz, $idCategory);
                    break;

                    case 'update-quiz':
                        $this->backController->updateQuiz($idQuiz, $_POST['nameQuiz'], $_POST['imageQuiz'], $_POST['idCategory']);
                        $this->backController->detailsQuiz($idQuiz);
                    break;
                    
                    case 'alert-quiz':
                        $this->backController->alertQuiz($idQuiz);
                    break;

                    case 'delete-quiz':
                        $this->backController->deleteQuiz($idQuiz);
                        $this->backController->detailsCategory($idCategory);
                    break;

                    // Question
                    case 'details-question':
                        $this->backController->detailsQuestion($idQuestion);
                    break;

                    case 'new-question':
                        $this->backController->newQuestion($idQuiz);
                    break;

                    case 'valid-new-question':
                        $this->backController->validNewQuestion($_POST['question'], $_POST['explanation'], $idQuiz);
                        $this->backController->detailsQuiz($idQuiz);
                    break;

                    case 'edit-question':
                        $this->backController->editQuestion($idQuestion);
                    break;

                    case 'update-question':
                        $this->backController->updateQuestion($idQuestion, $_POST['question'], $_POST['explanation']);
                        $this->backController->detailsQuestion($idQuestion);
                    break;

                    case 'alert-question':
                        $this->backController->alertQuestion($idQuestion);
                    break;

                    case 'delete-question':
                        $this->backController->deleteQuestion($idQuestion);
                        $this->backController->detailsQuiz($idQuiz);
                    break;

                    // Users
                    case 'users':
                        $this->backController->users();
                        unset($_SESSION['error_identifiant']);
                    break;

                    case 'details-user':
                        $this->backController->detailsUser($idUser);
                    break;

                    case 'new-user':
                        $this->backController->newUser();
                    break;

                    case 'valid-new-user':
                        $this->backController->validNewUser($_POST['identifiant'], $_POST['password'], $_POST['nameUser'], $_POST['lastnameUser'], $_POST['admin']);
                        $this->backController->users();
                    break;

                    case 'edit-user':
                        $this->backController->editUser($idUser);
                    break;

                    case 'update-user':
                        $this->backController->updateUser($idUser, $_POST['identifiant'], $_POST['password'], $_POST['nameUser'], $_POST['lastnameUser'], $_POST['admin']);
                        $this->backController->detailsUser($idUser);
                    break;

                    case 'alert-user':
                        $this->backController->alertUser($idUser);
                    break;

                    case 'delete-user':
                        $this->backController->deleteUser($idUser);
                        $this->backController->users();
                    break;
                }
            }
            else {
                $this->frontController->home();
            }
        }
        catch (Exception $e) {
            echo 'Erreur Router';
        }
    }
}