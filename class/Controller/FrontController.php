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
        $categories = $this->categoryDAO->getAllCategories();
        $allQuiz = $this->quizDAO->getHomeQuiz();
        foreach ($categories as $category) {
            $allCategories[] = new Category($category);
        }
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
            echo 'Erreur controller : Aucune catégorie identifiée';
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
            echo 'Erreur controller : Aucun quiz identifié';
        }
    }

    public function showQuizQuestions($idQuiz) {
        try {
            $singleQuiz = $this->quizDAO->getSingleQuiz($idQuiz);
            $questions = $this->questionDAO->getQuizQuestions($idQuiz);
            foreach ($singleQuiz as $quiz) {
                $oneQuiz[] = new Quiz($quiz);
            }
            foreach ($questions as $question) {
                $allQuestions[] = new Question($question);
            }
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