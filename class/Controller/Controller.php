<?php 
namespace App\Controller;

use App\DAO\QuizDAO;
use App\DAO\UserDAO;
use App\DAO\AnswerDAO;
use App\DAO\CategoryDAO;
use App\DAO\QuestionDAO;
use App\Entity\Category;
use App\Entity\Answer;
use App\Entity\Quiz;
use App\Entity\Question;
use App\Entity\User;

require('vendor/autoload.php');


class Controller {

    public $answerDAO;
    public $categoryDAO;
    public $questionDAO;
    public $quizDAO;
    public $userDAO;
    public $twig;

    public function __construct() {
        $this->answerDAO = new AnswerDAO;
        $this->categoryDAO = new CategoryDAO;
        $this->questionDAO = new QuestionDAO;
        $this->quizDAO = new QuizDAO;
        $this->userDAO = new UserDAO;
        $loader = new \Twig\Loader\FilesystemLoader('view');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
    }

    //Factorisation pour éviter les répétitions de récupération de données

    //Answers
    public function answers($idQuestion) {
        $answers = $this->answerDAO->getQuestionAnswers($idQuestion);
        if ($answers === []) {
            return null;
        } else {
            foreach ($answers as $answer) {
                $allAnswers[] = new Answer($answer);
            }
            return $allAnswers;
        }
    }

    //Categories
    public function singleCategory($idCategory) {
        $singleCategory = $this->categoryDAO->getSingleCategory($idCategory);
        foreach ($singleCategory as $category) {
            $oneCategory[] = new Category($category);
        }
        return $oneCategory;
    }

    public function allCategories() {
        $categories = $this->categoryDAO->getAllCategories();
        foreach ($categories as $category) {
            $allCategories[] = new Category($category);
        }
        return $allCategories;
    }

    //Questions
    public function singleQuestion($idQuestion) {
        $singleQuestion = $this->questionDAO->getSingleQuestion($idQuestion);
        foreach ($singleQuestion as $question) {
            $oneQuestion[] = new Question($question);
        }
        return $oneQuestion;
    }

    public function questions($idQuiz) {
        $questions = $this->questionDAO->getQuizQuestions($idQuiz);
        if ($questions === []) {
            return null;
        } else {
            foreach ($questions as $question) {
                $allQuestions[] = new Question($question);
            }
            return $allQuestions;
        }
    }

    //Quiz
    public function singleQuiz($idQuiz) {
        $singleQuiz = $this->quizDAO->getSingleQuiz($idQuiz);
        $allQuestions = $this->questions($idQuiz);
        foreach ($singleQuiz as $quiz) {
            $oneQuiz[] = new Quiz($quiz);
        }
        return $oneQuiz;
    }

    public function quizByCategory($idCategory) {
        $quizByCategory = $this->quizDAO->getQuizByCategory($idCategory);
        if ($quizByCategory === []) {
            return null;
        } else {
            foreach ($quizByCategory as $quiz) {
                $allQuiz[] = new Quiz($quiz);
            }
            return $allQuiz;
        }
    }

    //Users
    public function singleUser($idUser) {
        $singleUser = $this->userDAO->getSingleUser($idUser);
        foreach ($singleUser as $user) {
            $oneUser[] = new User($user);
        }
        return $oneUser;
    }
}