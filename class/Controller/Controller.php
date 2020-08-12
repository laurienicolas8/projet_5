<?php 

namespace App\Controller;

use App\DAO\AnswerDAO;
use App\DAO\CategoryDAO;
use App\DAO\QuestionDAO;
use App\DAO\QuizDAO;
use App\DAO\ResultDAO;
use App\DAO\UserDAO;

use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use App\Entity\Quiz;
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
        $this->twig->addGlobal('session', $_SESSION);
    }
    
    /**
     * loginPage
     * check if an user is connected
     * save the session variable user_connected
     * render the page dashboard
     * @return void
     */
    public function loginPage() {
        if (isset($_SESSION['user_connected'])) {
            $user = $_SESSION['user_connected'];
            echo $this->twig->render('dashboard.twig', [
                'user' => $user,
            ]);
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * login
     * fetch the identifiant typed
     * verify the password
     * create an user object with the user connected
     * create the session variable user_connected
     * render the page dashboard or an error message if identifiant and password don't match
     * @param  string $identifiant
     * @param  string $password
     * @return void
     */
    public function login($identifiant, $password) {
        // I check that the typed identifiant exists in database
        $userByIdentifiant = $this->userDAO->getUserByIdentifiant($identifiant);
        if (!empty($userByIdentifiant)) {
            // If it's the case, I check that the password corresponds 
            $passwordFound = $this->userDAO->getPasswordByIdentifiant($identifiant);
            $passwordHashed = $passwordFound[0]['password'];
            if (password_verify($password, $passwordHashed)) {
                // If the identifiant and the password are correct, I save the user connected in session variable and I call the dashboard
                foreach ($userByIdentifiant as $user) {
                    $userConnected = new User($user);
                }
                $_SESSION['user_connected'] = $userConnected;
                $user = $_SESSION['user_connected'];
                echo $this->twig->render('dashboard.twig', [
                    'user' => $user,
                ]);
            } else {
                // If the password doesn't correspond, I save in session variable an error message
                $_SESSION['error_login'] = 'La connexion est impossible, l\'identifiant ou le mot de passe n\'est pas correct';
                echo $this->twig->render('login.twig', [
                    'session' => $_SESSION,
                ]);
                if (isset($_SESSION['error_login'])) {
                    unset($_SESSION['error_login']);
                }
            }
        } else {
            // If the identifiant doesn't exit in database, I save in session variable an error message too
            $_SESSION['error_login'] = 'La connexion est impossible, l\'identifiant ou le mot de passe n\'est pas correct';
            echo $this->twig->render('login.twig', [
                'session' => $_SESSION,
            ]);
            if (isset($_SESSION['error_login'])) {
                unset($_SESSION['error_login']);
            }
        }
    }
    
    /**
     * logout
     * create the logout by deleting the session variable user_connected
     * @return void
     */
    public function logout() {
        if (isset($_SESSION['user_connected'])) {
            unset($_SESSION['user_connected']);
        } else {
            echo 'Erreur Controller : Impossible de se déconnecter, aucune connexion trouvée';
        }
    }

    // Factoring to avoid duplications of creating objects of database datas

    //Answers    
    /**
     * answersObject
     * fetch answers of the question concerned
     * create object foreach answer
     * @param  int $idQuestion
     * @return array or null
     */
    public function answersObject($idQuestion) {
        $answers = $this->answerDAO->getQuestionAnswers($idQuestion);
        // Avoid a php error
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
    /**
     * singleCategoryObject
     * fetch the category concerned
     * create object
     * @param  int $idCategory
     * @return array
     */
    public function singleCategoryObject($idCategory) {
        $singleCategory = $this->categoryDAO->getSingleCategory($idCategory);
        foreach ($singleCategory as $category) {
            $oneCategory[] = new Category($category);
        }
        return $oneCategory;
    }
    
    /**
     * allCategoriesObject
     * fetch all categories
     * create object foreach category
     * @return array
     */
    public function allCategoriesObject() {
        $categories = $this->categoryDAO->getAllCategories();
        foreach ($categories as $category) {
            $allCategories[] = new Category($category);
        }
        return $allCategories;
    }

    //Questions    
    /**
     * singleQuestionObject
     * fetch the question concerned
     * create object
     * @param  int $idQuestion
     * @return array
     */
    public function singleQuestionObject($idQuestion) {
        $singleQuestion = $this->questionDAO->getSingleQuestion($idQuestion);
        foreach ($singleQuestion as $question) {
            $oneQuestion[] = new Question($question);
        }
        return $oneQuestion;
    }
    
    /**
     * questionsObject
     * fetch the questions of the quiz concerned
     * create object foreach question
     * @param  int $idQuiz
     * @return array or null
     */
    public function questionsObject($idQuiz) {
        $questions = $this->questionDAO->getQuizQuestions($idQuiz);
        // Avoid a php error
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
    /**
     * singleQuizObject
     * fetch the quiz concerned
     * fetch the questions of the quiz concerned
     * create object 
     * @param  int $idQuiz
     * @return array
     */
    public function singleQuizObject($idQuiz) {
        $singleQuiz = $this->quizDAO->getSingleQuiz($idQuiz);
        $allQuestions = $this->questionsObject($idQuiz);
        foreach ($singleQuiz as $quiz) {
            $oneQuiz[] = new Quiz($quiz);
        }
        return $oneQuiz;
    }
    
    /**
     * quizByCategoryObject
     * fetch quiz of the category concerned
     * create object foreach quiz
     * @param  int $idCategory
     * @return array or null
     */
    public function quizByCategoryObject($idCategory) {
        $quizByCategory = $this->quizDAO->getQuizByCategory($idCategory);
        // Avoid a php error
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
    /**
     * singleUserObject
     * fetch the user concerned
     * create object
     * @param  int $idUser
     * @return array
     */
    public function singleUserObject($idUser) {
        $singleUser = $this->userDAO->getSingleUser($idUser);
        foreach ($singleUser as $user) {
            $oneUser[] = new User($user);
        }
        return $oneUser;
    }
}