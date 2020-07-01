<?php
namespace App\Controller;

use Exception;

require('../vendor/autoload.php');

class FrontController extends \Controller {

    public $answerDAO;
    public $categoryDAO;
    public $questionDAO;
    public $quizDAO;
    public $userDAO;

    public function __construct() {
        $this->answerDAO = new projet_5\DAO\AnswerDAO();
        $this->categoryDAO = new projet_5\DAO\CategoryDAO();
        $this->questionDAO = new projet_5\DAO\QuestionDAO();
        $this->quizDAO = new projet_5\DAO\QuizDAO();
        $this->userDAO = new projet_5\DAO\UserDAO();
    }
    
    public function home() {
        $sliderQuiz = $this->quizDAO->getSliderQuiz();
        $categories = $this->categoryDAO->getAllCategories();
        $homeQuiz = $this->quizDAO->getHomeQuiz();
        require('../view/frontend/home.php');
    }

    public function allCategories() {
        $categories = $this->categoryDAO->getAllCategories();
        require('../view/frontend/all_categories.php');
    }

    public function allQuiz() {
        $quiz = $this->quizDAO->getAllQuiz();
        require('../view/frontend/all_quiz.php');
    }

    public function singleCategory($idCategory) {
        try {
            $category = $this->categoryDAO->getSingleCategory($idCategory);
            $quiz = $this->quizDAO->getQuizByCategory($idCategory);
            require('../view/frontend/single_category.php');
        } catch (Exception $e) {
            echo 'Erreur : Catégorie inconnue';
        }
    }

    public function startQuiz($idQuiz) {
        try {
            $quiz = $this->quizDAO->getSingleQuiz($idQuiz);
            require('../view/frontend/start_quiz.php');
        } catch (Exception $e) {
            echo 'Erreur : Quiz inconnu';
        }
    }

    public function showQuizQuestions($idQuiz) { // answers ?
        try {
            $quiz = $this->quizDAO->getSingleQuiz($idQuiz);
            $questions = $this->questionDAO->getQuizQuestions($idQuiz);
            require('../view/frontend/start_quiz.php');
        } catch (Exception $e) {
            echo 'Erreur : Quiz inconnu';
        }
    }
}