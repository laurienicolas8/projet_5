<?php
namespace App\Controller;

use Exception;
use App\Controller\Controller;

require('vendor/autoload.php');

class FrontController extends Controller {
    
    public function home() {
        $sliderQuiz = $this->quizDAO->getSliderQuiz();
        $categories = $this->categoryDAO->getAllCategories();
        $homeQuiz = $this->quizDAO->getHomeQuiz();
        require_once('view/frontend/home.php');
    }

    public function allQuiz() {
        $quiz = $this->quizDAO->getAllQuiz();
        require_once('view/frontend/all_quiz.php');
    }

    public function singleCategory($idCategory) {
        try {
            $category = $this->categoryDAO->getSingleCategory($idCategory);
            $quiz = $this->quizDAO->getQuizByCategory($idCategory);
            require('view/frontend/single_category.php');
        } catch (Exception $e) {
            echo 'Erreur : Catégorie inconnue';
        }
    }

    public function startQuiz($idQuiz) {
        try {
            $quiz = $this->quizDAO->getSingleQuiz($idQuiz);
            require('view/frontend/start_quiz.php');
        } catch (Exception $e) {
            echo 'Erreur : Quiz inconnu';
        }
    }

    public function showQuizQuestions($idQuiz) { // answers ?
        try {
            $quiz = $this->quizDAO->getSingleQuiz($idQuiz);
            $questions = $this->questionDAO->getQuizQuestions($idQuiz);
            require('view/frontend/start_quiz.php');
        } catch (Exception $e) {
            echo 'Erreur : Quiz inconnu';
        }
    }
}