<?php
namespace App\Controller;

use Exception;
use App\Entity\Quiz;
use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use App\Controller\Controller;

require('vendor/autoload.php');
require_once('config.php');

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
            $countQuestions = $this->questionDAO->getCountQuizQuestions($idQuiz);
            foreach ($countQuestions as $count) {
                $oneCount = $count;
            }
            $allQuestions = $this->questionsObject($idQuiz);
            $_SESSION['quiz_questions'] = $allQuestions;
            // Je récupère le premier index pour accéder à la première question du quiz
            $questions = $_SESSION['quiz_questions'];
            $firstQuestionIndex = array_key_first($questions);
            echo $this->twig->render('start_quiz.twig', [
                'oneQuiz' => $oneQuiz,
                'questions' => $questions,
                'firstQuestionIndex' => $firstQuestionIndex,
                'oneCount' => $oneCount,
            ]);
            
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun quiz identifié';
        }
    }

    public function question($indexQuestion, $idQuiz) {
        try {
            $oneQuiz = $this->singleQuizObject($idQuiz);
            if (isset($_SESSION['quiz_questions'])) {
                $questions = $_SESSION['quiz_questions'];
                // Je récupère l'id de la question actuelle pour la récupérer en base
                $idCurrentQuestion = $questions[$indexQuestion]->idQuestion();
            } else {
                echo "Erreur : Aucune question n'a été trouvée dans ce quiz";
            }
            $singleQuestion = $this->singleQuestionObject($idCurrentQuestion);
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
                'questions' => $questions,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun quiz identifié';
        }
    }

    public function checkAnswer($idAnswer, $idQuestion) {
        try {
            $rightAnswerQuestion = $this->answerDAO->getRightAnswer($idQuestion);
            foreach ($rightAnswerQuestion as $answer) {
                $rightAnswer[] = new Answer($answer);
            }
            $idRightAnswer = $rightAnswer[0]->idAnswer();
            if ($idRightAnswer == $idAnswer) {
                $this->resultDAO->addResult(1);
            } else {
                $this->resultDAO->addResult(0);
            }
        } catch (Exception $e) {
            echo 'Erreur : Aucune réponse n\'a été sélectionnée';
        }
    }

    public function rightAnswer() {
        try {
            $oneQuiz = $this->singleQuizObject($idQuiz);
            if (isset($_SESSION['quiz_questions'])) {
                $questions = $_SESSION['quiz_questions'];
                $lastQuestionIndex = array_key_last($questions);
                // Je récupère l'id de la question actuelle pour la récupérer en base
                $idCurrentQuestion = $questions[$indexQuestion]->idQuestion();
                // Je définis l'index de la question suivante
                if ($indexQuestion + 1 <= $lastQuestionIndex) {
                    $nextQuestionIndex = $indexQuestion + 1;
                } else {
                    $nextQuestionIndex = null;
                }
            } else {
                echo "Erreur : Aucune question n'a été trouvée dans ce quiz";
            }
            $singleQuestion = $this->singleQuestionObject($idCurrentQuestion);
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
                'questions' => $questions,
                'indexCurrentQuestion' => $indexQuestion,
                'lastQuestionIndex' => $lastQuestionIndex,
                'nextQuestionIndex' => $nextQuestionIndex,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun quiz identifié';
        }
    }
}