<?php
namespace App\Controller;

use Exception;
use App\Entity\Quiz;
use App\Entity\Category;
use App\Entity\Question;
use App\Controller\Controller;

require('vendor/autoload.php');

class FrontController extends Controller {
    
    public function home() {
        $categories = $this->categoryDAO->getAllCategories();
        $allQuiz = $this->quizDAO->getHomeQuiz();
        foreach ($categories as $category) {
            $allCategories[] = new Category($category);
        }
        foreach ($allQuiz as $quiz) {
            $homeQuiz[] = new Quiz($quiz);
        }
        echo $this->twig->render('home.twig', [
            'allCategories' => $allCategories, 
            'homeQuiz' => $homeQuiz,
        ]);
    }

    public function allQuiz() {
        $quiz = $this->quizDAO->getAllQuiz();
        foreach ($quiz as $oneQuiz) {
            $allQuiz[] = new Quiz($oneQuiz);
        }
        echo $this->twig->render('all_quiz.twig', [
            'allQuiz' => $allQuiz,
        ]);
    }

    public function singleCategory($idCategory) {
        try {
            $singleCategory = $this->categoryDAO->getSingleCategory($idCategory);
            $quizByCategory = $this->quizDAO->getQuizByCategory($idCategory);
            foreach ($singleCategory as $category) {
                $oneCategory[] = new Category($category);
            }
            foreach ($quizByCategory as $quiz) {
                $allQuiz[] = new Quiz($quiz);
            }
            echo $this->twig->render('single_category.twig', [
                'oneCategory' => $oneCategory,
                'allQuiz' => $allQuiz,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucune catégorie identifiée';
        }
    }

    public function startQuiz($idQuiz) {
        try {
            $singleQuiz = $this->quizDAO->getSingleQuiz($idQuiz);
            $countQuestions = $this->questionDAO->getCountQuizQuestions($idQuiz);
            foreach ($singleQuiz as $quiz) {
                $oneQuiz[] = new Quiz($quiz);
            }
            foreach ($countQuestions as $count) {
                $oneCount = $count;
            }
            echo $this->twig->render('start_quiz.twig', [
                'oneQuiz' => $oneQuiz,
                'oneCount' => $oneCount,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucun quiz identifié';
        }
    }

    public function showQuizQuestions($idQuiz) { // answers ?
        try {
            $singleQuiz = $this->quizDAO->getSingleQuiz($idQuiz);
            $questions = $this->questionDAO->getQuizQuestions($idQuiz);
            foreach ($singleQuiz as $quiz) {
                $oneQuiz[] = new Quiz($quiz);
            }
            foreach ($questions as $question) {
                $allQuestions[] = new Question($question);
            }
            echo $this->twig->render('questions.twig', [
                'oneQuiz' => $oneQuiz,
                'allQuestions' => $allQuestions,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucun quiz identifié';
        }
    }

    public function login() {
        echo $this->twig->render('login.twig');
    }
}