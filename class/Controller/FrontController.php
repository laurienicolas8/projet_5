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
        foreach ($categories as $category) {
            // Si une catégorie ne contient aucun quiz, alors elle n'apparait pas
            $quiz = $this->quizByCategoryObject($category['idCategory']);
            if ($quiz !== null) { 
                $allCategories[] = new Category($category);
            }
        }
        $allQuiz = $this->quizDAO->getHomeQuiz();
        foreach ($allQuiz as $quiz) {
            $questions = $this->questionsObject($quiz['idQuiz']);
            if ($questions !== null) {
                // Récupérer le nom de la catégorie de chaque quiz
                $quizCategory[] = $quiz['idCategory'];
                $homeQuiz[] = new Quiz($quiz);
            }
        }
        // Supprimer les doublons si 2 quiz ont la même catégorie
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
                // Si un quiz ne contient aucune question, alors il n'apparait pas
                $questions = $this->questionsObject($oneQuiz['idQuiz']);
                if ($questions !== null) {
                   $quizCategory[] = $oneQuiz['idCategory'];
                    $allQuiz[] = new Quiz($oneQuiz); 
                }
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
            $oneCategory = $this->singleCategoryObject($idCategory);
            $quiz = $this->quizDAO->getQuizByCategory($idCategory);
            foreach ($quiz as $oneQuiz) {
                $questions = $this->questionsObject($oneQuiz['idQuiz']);
                if ($questions !== null) {
                    $allQuiz[] = new Quiz($oneQuiz); 
                }
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
            $oneQuiz = $this->singleQuizObject($idQuiz);
            $allQuestions = $this->questionsObject($idQuiz);
            $countQuestions = $this->questionDAO->getCountQuizQuestions($idQuiz);
            foreach ($countQuestions as $count) {
                $oneCount = $count;
            }
            echo $this->twig->render('start_quiz.twig', [
                'oneQuiz' => $oneQuiz,
                'allQuestions' => $allQuestions,
                'oneCount' => $oneCount,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun quiz identifié';
        }
    }

    public function firstQuestion($idQuestion, $idQuiz) {
        try {
            $oneQuiz = $this->singleQuizObject($idQuiz);
            $singleQuestion = $this->singleQuestionObject($idQuestion);
            foreach ($singleQuestion as $question) {
                $answers = $this->answerDAO->getQuestionAnswers($question->idQuestion());
                foreach ($answers as $answer) {
                    $allAnswers[] = new Answer($answer);
                }
            }
            echo $this->twig->render('questions.twig', [
                'oneQuiz' => $oneQuiz,
                'singleQuestion' => $singleQuestion,
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