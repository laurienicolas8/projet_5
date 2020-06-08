<?php 

class Controller {

    protected $quizDAO;
    protected $categoryDAO;
    protected $questionDAO;
    protected $answerDAO;
    protected $levelDAO;
    protected $userDAO;

    public function __construct() {
        require('./DAO/QuizDAO');
        require('./DAO/CategoryDAO');
        require('./DAO/QuestionDAO');
        require('./DAO/AnswerDAO');
        require('./DAO/LevelDAO');
        require('./DAO/UserDAO');
        $this->quiz = new QuizDAO;
        $this->category = new CategoryDAO;
        $this->question = new QuestionDAO;
        $this->answer = new AnswerDAO;
        $this->level = new LevelDAO;
        $this->user = new UserDAO;
    }

    
}