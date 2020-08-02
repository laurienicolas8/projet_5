<?php 
namespace App\Controller;

use App\DAO\QuizDAO;
use App\DAO\UserDAO;
use App\DAO\AnswerDAO;
use App\DAO\CategoryDAO;
use App\DAO\QuestionDAO;
use App\DAO\ResultDAO;

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
    public $resultDAO;
    public $userDAO;
    public $twig;

    public function __construct() {
        $this->answerDAO = new AnswerDAO;
        $this->categoryDAO = new CategoryDAO;
        $this->questionDAO = new QuestionDAO;
        $this->quizDAO = new QuizDAO;
        $this->resultDAO = new ResultDAO;
        $this->userDAO = new UserDAO;
        $loader = new \Twig\Loader\FilesystemLoader('view');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
    }

    public function loginPage() {
        echo $this->twig->render('login.twig');
    }

    public function login($identifiant, $password) {
        // Je vérifie si l'identifiant saisi existe en base de données
        $userByIdentifiant = $this->userDAO->getUserByIdentifiant($identifiant);
        if (!empty($userByIdentifiant)) {
            // Si c'est le cas, je vérifie si le password saisi lui correspond
            $passwordFound = $this->userDAO->getPasswordByIdentifiant($identifiant);
            $passwordHashed = $passwordFound[0]['password'];
            if (password_verify($password, $passwordHashed)) {
                // Si l'identifiant et le mot de passe sont corrects, j'enregistre l'utilisateur qui s'est connecté en variable de session et j'appelle le dashboard
                foreach ($userByIdentifiant as $user) {
                    $userConnected = new User($user);
                }
                $_SESSION['user_connected'] = $userConnected;
                echo $this->twig->render('dashboard.twig', [
                    'session' => $_SESSION,
                ]);
            } else {
                // Si le mot de passe ne correspond pas, j'enregistre en session de variable un message d'erreur
                $_SESSION['error_login'] = 'La connexion est impossible, l\'identifiant ou le mot de passe n\'est pas correct';
                echo $this->twig->render('login.twig', [
                    'session' => $_SESSION,
                ]);
                if (isset($_SESSION['error_login'])) {
                    unset($_SESSION['error_login']);
                }
            }
        } else {
            // Si l'identifiant n'existe pas en base, j'enregistre aussi en session de variable un message d'erreur
            $_SESSION['error_login'] = 'La connexion est impossible, l\'identifiant ou le mot de passe n\'est pas correct';
            echo $this->twig->render('login.twig', [
                'session' => $_SESSION,
            ]);
            if (isset($_SESSION['error_login'])) {
                unset($_SESSION['error_login']);
            }
        }
    }

    //Factorisation pour éviter les répétitions de récupération de données

    //Answers
    public function answersObject($idQuestion) {
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
    public function singleCategoryObject($idCategory) {
        $singleCategory = $this->categoryDAO->getSingleCategory($idCategory);
        foreach ($singleCategory as $category) {
            $oneCategory[] = new Category($category);
        }
        return $oneCategory;
    }

    public function allCategoriesObject() {
        $categories = $this->categoryDAO->getAllCategories();
        foreach ($categories as $category) {
            $allCategories[] = new Category($category);
        }
        return $allCategories;
    }

    //Questions
    public function singleQuestionObject($idQuestion) {
        $singleQuestion = $this->questionDAO->getSingleQuestion($idQuestion);
        foreach ($singleQuestion as $question) {
            $oneQuestion[] = new Question($question);
        }
        return $oneQuestion;
    }

    public function questionsObject($idQuiz) {
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
    public function singleQuizObject($idQuiz) {
        $singleQuiz = $this->quizDAO->getSingleQuiz($idQuiz);
        $allQuestions = $this->questionsObject($idQuiz);
        foreach ($singleQuiz as $quiz) {
            $oneQuiz[] = new Quiz($quiz);
        }
        return $oneQuiz;
    }

    public function quizByCategoryObject($idCategory) {
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
    public function singleUserObject($idUser) {
        $singleUser = $this->userDAO->getSingleUser($idUser);
        foreach ($singleUser as $user) {
            $oneUser[] = new User($user);
        }
        return $oneUser;
    }
}