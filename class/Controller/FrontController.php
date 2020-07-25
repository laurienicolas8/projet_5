<?php
namespace App\Controller;

use Exception;
use App\Entity\Quiz;
use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use App\Controller\Controller;

require('vendor/autoload.php');

class FrontController extends Controller {
    
    public function home() {
        $allCategories = $this->allCategories();
        $allQuiz = $this->quizDAO->getHomeQuiz();
        foreach ($allQuiz as $quiz) {
            $quizCategory[] = $quiz['idCategory'];
            $homeQuiz[] = new Quiz($quiz);
        }
        // Supprimer les doublons pour éviter les doublons de catégorie dans la view
        $quizUnique = array_unique($quizCategory);
        foreach ($quizUnique as $quiz) {
            $singleCategory = $this->categoryDAO->getSingleCategory($quiz);
            foreach ($singleCategory as $category) {
                $oneCategory[] = new Category($category);
            }
        }
        echo $this->twig->render('home.twig', [
            'allCategories' => $allCategories, 
            'homeQuiz' => $homeQuiz,
            'oneCategory' => $oneCategory,
        ]);
    }

    public function allQuiz($currentPage) {
        try {
            $quiz = $this->quizDAO->getAllQuiz($currentPage);
            foreach ($quiz as $oneQuiz) {
                $quizCategory[] = $oneQuiz['idCategory'];
                $allQuiz[] = new Quiz($oneQuiz);
            }
            // Supprimer les doublons pour éviter les doublons de catégorie dans la view
            $quizUnique = array_unique($quizCategory);
            foreach ($quizUnique as $quiz) {
                $singleCategory = $this->categoryDAO->getSingleCategory($quiz);
                foreach ($singleCategory as $category) {
                    $oneCategory[] = new Category($category);
                }
            }
            echo $this->twig->render('all_quiz.twig', [
                'allQuiz' => $allQuiz,
                'oneCategory' => $oneCategory,
                'nbPages' => $this->quizDAO->nbPages,
                'currentPage' => $currentPage,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : La numéro de la page est inconnu';
        }
    }

    public function detailSingleCategory($idCategory) {
        try {
            $oneCategory = $this->singleCategory($idCategory);
            $allQuiz = $this->quizByCategory($idCategory);
            echo $this->twig->render('single_category.twig', [
                'oneCategory' => $oneCategory,
                'allQuiz' => $allQuiz,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucune catégorie identifiée';
        }
    }

    public function startQuiz($idQuiz) {
        try {
            $oneQuiz = $this->singleQuiz($idQuiz);
            $countQuestions = $this->questionDAO->getCountQuizQuestions($idQuiz);
            foreach ($countQuestions as $count) {
                $oneCount = $count;
            }
            echo $this->twig->render('start_quiz.twig', [
                'oneQuiz' => $oneQuiz,
                'oneCount' => $oneCount,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun quiz identifié';
        }
    }

    public function showQuizQuestions($idQuiz) {
        try {
            $oneQuiz = $this->singleQuiz($idQuiz);
            $allQuestions = $this->questions($idQuiz);
            foreach ($allQuestions as $oneQuestion) {
                $answers = $this->answerDAO->getQuestionAnswers($oneQuestion->idQuestion());
                foreach ($answers as $answer) {
                    $allAnswers[] = new Answer($answer);
                }
            }
            echo $this->twig->render('questions.twig', [
                'oneQuiz' => $oneQuiz,
                'allQuestions' => $allQuestions,
                'allAnswers' => $allAnswers,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun quiz identifié';
        }
    }

    public function login() {
        echo $this->twig->render('login.twig');
    }
}