<?php 
namespace App\Controller;

use App\DAO\QuizDAO;
use App\DAO\UserDAO;
use App\DAO\AnswerDAO;
use App\DAO\CategoryDAO;
use App\DAO\QuestionDAO;

require('vendor/autoload.php');

class Controller {

    public $answerDAO;
    public $categoryDAO;
    public $questionDAO;
    public $quizDAO;
    public $userDAO;

    public function __construct() {
        $this->answerDAO = new AnswerDAO;
        $this->categoryDAO = new CategoryDAO;
        $this->questionDAO = new QuestionDAO;
        $this->quizDAO = new QuizDAO;
        $this->userDAO = new UserDAO;
    }
}