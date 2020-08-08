<?php

namespace App\Controller;

use Exception;
use App\Entity\Answer;
use App\Entity\Category;
use App\Controller\Controller;
use App\Entity\Question;
use App\Entity\Quiz;

require('vendor/autoload.php');

class FrontController extends Controller {
        
    /**
     * home
     * fetch all categories and creating object if the category is not empty
     * fetch the home quiz
     * delete duplications in the array categories for the quiz cards in home
     * render the page home
     * @return void
     */
    public function home() {
        $categories = $this->categoryDAO->getAllCategories();
        foreach ($categories as $category) {
            $allCategories[] = new Category($category);
        }
        $allQuiz = $this->quizDAO->getHomeQuiz();
        foreach ($allQuiz as $quiz) {
            $questions = $this->questionsObject($quiz['idQuiz']);
            // I fetch the category of the quiz
            $quizCategory[] = $quiz['idCategory'];
            $homeQuiz[] = new Quiz($quiz);
        }
        // Delete duplications to avoid duplications in quiz cards
        $quizUnique = array_unique($quizCategory);
        foreach ($quizUnique as $quiz) {
            $singleCategory = $this->categoryDAO->getSingleCategory($quiz);
            foreach ($singleCategory as $category) {
                $oneCategory[] = new Category($category);
            }
        }
        echo $this->twig->render('home.twig', [
            'session' => $_SESSION,
            'allCategories' => $allCategories, 
            'homeQuiz' => $homeQuiz,
            'oneCategory' => $oneCategory,
        ]);
    }
    
    /**
     * allQuiz
     * fetch all quiz of the current page
     * check if the quiz contents questions
     * delete the duplication in the array categories for the quiz cards
     * render the page all_quiz
     * @param  int $currentPage
     * @return void
     */
    public function allQuiz($currentPage) {
        try {
            $quiz = $this->quizDAO->getAllQuiz($currentPage);
            foreach ($quiz as $oneQuiz) {
                $quizCategory[] = $oneQuiz['idCategory'];
                $allQuiz[] = new Quiz($oneQuiz);
            }
            // Delete duplications to avoid duplications in the quiz cards in view
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
    
    /**
     * detailSingleCategory
     * fetch the category concerned and all its quiz
     * create objects
     * render the page single_category
     * @param  int $idCategory
     * @return void
     */
    public function detailSingleCategory($idCategory) {
        try {
            $oneCategory = $this->singleCategoryObject($idCategory);
            $quiz = $this->quizDAO->getQuizByCategory($idCategory);
            if ($quiz !== []) {
                foreach ($quiz as $oneQuiz) {
                    $allQuiz[] = new Quiz($oneQuiz);  
                }
            } else {
                $allQuiz = null;
            }
            echo $this->twig->render('single_category.twig', [
                'oneCategory' => $oneCategory,
                'allQuiz' => $allQuiz,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucune catégorie identifiée';
        }
    }
    
    /**
     * startQuiz
     * fetch the quiz concerned and count its questions
     * create a session variable of all the questions of the quiz
     * fetch the first index / the first question
     * render the page start_quiz
     * @param  int $idQuiz
     * @return void
     */
    public function startQuiz($idQuiz) {
        try {
            $oneQuiz = $this->singleQuizObject($idQuiz);
            $countQuestions = $this->questionDAO->getCountQuizQuestions($idQuiz);
            foreach ($countQuestions as $count) {
                $oneCount = $count;
            }
            $allQuestions = $this->questionsObject($idQuiz);
            $_SESSION['quiz_questions'] = $allQuestions;
            // I fetch the first index to access the first question of the quiz
            $questions = $_SESSION['quiz_questions'];
            if ($questions !== null) {
                $firstQuestionIndex = array_key_first($questions);
            } else {
                $firstQuestionIndex = null;
            }
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
    
    /**
     * question
     * fetch the quiz concerned
     * check that the questions has been fetched in session variable quiz_questions
     * fetch the id of the current question and its answer
     * render the page questions
     * @param  int $indexQuestion
     * @param  int $idQuiz
     * @return void
     */
    public function question($indexQuestion, $idQuiz) {
        try {
            $oneQuiz = $this->singleQuizObject($idQuiz);
            // I check that the questions has been fetched in start_quiz
            if (isset($_SESSION['quiz_questions'])) {
                $questions = $_SESSION['quiz_questions'];
                // I fetch the id of the current question to fetch it in database
                $idCurrentQuestion = $questions[$indexQuestion]->idQuestion();
                // I fetch the current question and its answers to display
                $singleQuestion = $this->singleQuestionObject($idCurrentQuestion);
                foreach ($singleQuestion as $question) {
                    $answers = $this->answerDAO->getQuestionAnswers($question->idQuestion());
                    if ($answers !== []) {
                        foreach ($answers as $answer) {
                            $allAnswers[] = new Answer($answer);
                        }
                    } else {
                        $allAnswers = null;
                    }
                }
            } else {
                echo 'Erreur : Aucune question n\'a été trouvée dans ce quiz';
            }
            echo $this->twig->render('questions.twig', [
                'oneQuiz' => $oneQuiz,
                'singleQuestion' => $singleQuestion,
                'allAnswers' => $allAnswers,
                'questions' => $questions,
                'indexCurrentQuestion' => $indexQuestion,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun quiz identifié';
        }
    }
    
    /**
     * checkAnswer
     * fetch the right answer
     * create an object
     * compare id right answer and id player answer
     * create a session variable right answer or bad answer
     * @param  int $idAnswer
     * @param  int $idQuestion
     * @return void
     */
    public function checkAnswer($idAnswer, $idQuestion) {
        try {
            // I fetch the right answer of the current question
            $rightAnswerQuestion = $this->answerDAO->getRightAnswer($idQuestion);
            // I make an object to fetch its id
            foreach ($rightAnswerQuestion as $answer) {
                $rightAnswer[] = new Answer($answer);
            }
            $idRightAnswer = $rightAnswer[0]->idAnswer();
            // I compare its id with the id of the player's answer
            if ($idRightAnswer == $idAnswer) {
                $this->resultDAO->addResult(1);
                $_SESSION['right_answer'] = 'Bonne réponse !';
            } else {
                $this->resultDAO->addResult(0);
                $_SESSION['wrong_answer'] = 'Mauvaise réponse !';
            }
        } catch (Exception $e) {
            echo 'Erreur : Aucune réponse n\'a été sélectionnée';
        }
    }
    
    /**
     * answer
     * fetch the quiz concerned
     * check if the questions of the quiz has been fetched in session variable
     * fetch the last index in the array to know where the quiz takes end
     * define the next question index
     * fetch the question and its answers and creating objects with controller method
     * render the page answer
     * @param  string $answerPlayer
     * @param  int $indexQuestion
     * @param  int $idQuiz
     * @return void
     */
    public function answer($answerPlayer, $indexQuestion, $idQuiz) {
        try {
            $oneQuiz = $this->singleQuizObject($idQuiz);
            // I check that the questions has been fetched in start_quiz
            if (isset($_SESSION['quiz_questions'])) {
                // I fetch the last in the array to adapt the button at the end of the quiz
                $questions = $_SESSION['quiz_questions'];
                $lastQuestionIndex = array_key_last($questions);
                // I fetch the current question id to fetch it in database
                $idCurrentQuestion = $questions[$indexQuestion]->idQuestion();
                // I define the next question index
                if ($indexQuestion + 1 <= $lastQuestionIndex) {
                    $nextQuestionIndex = $indexQuestion + 1;
                } else {
                    $nextQuestionIndex = null;
                }
                // I fetch the current question and its answers to display
                $singleQuestion = $this->singleQuestionObject($idCurrentQuestion);
                foreach ($singleQuestion as $question) {
                    $answers = $this->answerDAO->getQuestionAnswers($question->idQuestion());
                    foreach ($answers as $answer) {
                        $allAnswers[] = new Answer($answer);
                    }
                }
            } else {
                echo 'Erreur : Aucune question n\'a été trouvée dans ce quiz';
            }
            echo $this->twig->render('answer.twig', [
                'session' => $_SESSION,
                'answerPlayer' => $answerPlayer,
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
    
    /**
     * result
     * fetch the quiz concerned and the count of its questions
     * fetch all points won on the quiz
     * calculating the sum of all points
     * render the page result
     * then delete all results and delete the session variable of the quiz questions
     * @param  int $idQuiz
     * @return void
     */
    public function result($idQuiz) {
        try {
            $oneQuiz = $this->singleQuizObject($idQuiz);
            $countQuestions = $this->questionDAO->getCountQuizQuestions($idQuiz);
            foreach ($countQuestions as $count) {
                $oneCount = $count;
            }
            $allResults = $this->resultDAO->getResults();
            if (!empty($allResults)) {
                foreach ($allResults as $results) {
                    $points[] = $results['result'];
                }
                $score = array_sum($points);
                echo $this->twig->render('result.twig', [
                    'oneQuiz' => $oneQuiz,
                    'score' => $score,
                    'oneCount' => $oneCount,
                ]);
                $this->resultDAO->supprResults();
                unset($_SESSION['quiz_questions']);
            } else {
                echo 'Erreur : Aucun quiz joué, aucun résultat';
            }
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun quiz identifié';
        }
    }
}