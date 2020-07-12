<?php 
namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Controller\Controller;

require('vendor/autoload.php');


class BackController extends Controller {
    
    public function dashboard() {
        $countCategories = $this->categoryDAO->getCountCategories();
        $countQuiz = $this->quizDAO->getCountQuiz();
        $countQuestions = $this->questionDAO->getCountQuestions();
        echo $this->twig->render('dashboard.twig', [
            'countCategories' => $countCategories, 
            'countQuiz' => $countQuiz, 
            'countQuestions' => $countQuestions, 
        ]);
    }

    public function categories() {
        $categories = $this->categoryDAO->getAllCategories();
        foreach ($categories as $category) {
            $allCategories[] = new Category($category);
        }
        echo $this->twig->render('categories.twig', [
            'allCategories' => $allCategories, 
        ]);
    }

    public function newCategory() {
        echo $this->twig->render('new_category.twig');
    }

    public function editCategory($idCategory) {
        try {
            $singleCategory = $this->categoryDAO->getSingleCategory($idCategory);
            foreach ($singleCategory as $category) {
                $oneCategory[] = new Category($category);
            }
            echo $this->twig->render('edit_category.twig', [
                'oneCategory' => $oneCategory,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucune catégorie identifiée';
        }
    }

    public function alertCategory($idCategory) {
        try {
            $singleCategory = $this->categoryDAO->getSingleCategory($idCategory);
            foreach ($singleCategory as $category) {
                $oneCategory[] = new Category($category);
            }
            echo $this->twig->render('alert_category.twig', [
                'oneCategory' => $oneCategory,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucune catégorie identifiée';
        }
    }

    public function detailsCategory($idCategory) {
        try {
            $singleCategory = $this->categoryDAO->getSingleCategory($idCategory);
            $quizByCategory = $this->quizDAO->getQuizByCategory($idCategory);
            foreach ($singleCategory as $category) {
                $oneCategory[] = new Category($category);
            }
            foreach ($quizByCategory as $quiz) {
                $allQuiz[] = new Quiz($quiz);
            }
            echo $this->twig->render('details_category.twig', [
                'oneCategory' => $oneCategory,
                'allQuiz' => $allQuiz,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucune catégorie identifiée';
        }
    }

    public function quiz() {
        $quiz = $this->quizDAO->getAllQuiz();
        foreach ($quiz as $oneQuiz) {
            $allQuiz[] = new Quiz($oneQuiz);
        }
        echo $this->twig->render('quiz.twig', [
            'allQuiz' => $allQuiz,
        ]);
    }

    public function newQuiz() {
        echo $this->twig->render('new_quiz.twig');
    }

    public function editQuiz($idQuiz) {
        try {
            $singleQuiz = $this->categoryDAO->getSingleQuiz($idQuiz);
            foreach ($singleQuiz as $quiz) {
                $oneQuiz[] = new Quiz($quiz);
            }
            echo $this->twig->render('edit_quiz.twig', [
                'oneQuiz' => $oneQuiz,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucun quiz identifié';
        }
    }

    public function alertQuiz($idQuiz) {
        try {
            $singleQuiz = $this->categoryDAO->getSingleQuiz($idQuiz);
            foreach ($singleQuiz as $quiz) {
                $oneQuiz[] = new Quiz($quiz);
            }
            echo $this->twig->render('alert_quiz.twig', [
                'oneQuiz' => $oneQuiz,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucun quiz identifié';
        }
    }

    public function detailsQuiz($idQuiz) {
        try {
            $singleQuiz = $this->quizDAO->getSingleQuiz($idQuiz);
            $questions = $this->questionDAO->getQuizQuestions($idQuiz);
            foreach ($singleQuiz as $quiz) {
                $oneQuiz[] = new Quiz($quiz);
            }
            foreach ($questions as $question) {
                $allQuestions[] = new Question($question);
            }
            echo $this->twig->render('details_quiz.twig', [
                'oneQuiz' => $oneQuiz,
                'allQuestions' => $allQuestions,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucun quiz identifié';
        }
    }

    public function detailsQuestion($idQuestion) {
        try {
            $singleQuestion = $this->questionDAO->getSingleQuestion($idQuestion);
            $answers = $this->answerDAO->getQuestionAnswers($idQuestion);
            foreach ($singleQuestion as $question) {
                $oneQuestion[] = new Question($question);
            }
            foreach ($answers as $answer) {
                $allAnswers[] = new Answer($answer);
            }
            echo $this->twig->render('details_question.twig', [
                'oneQuestion' => $oneQuestion,
                'allAnswers' => $allAnswers,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucune question identifiée';
        }
    }

    public function users() {
        $users = $this->userDAO->getAllUsers();
        foreach ($users as $user) {
            $allUsers[] = new User($user);
        }
        echo $this->twig->render('users.twig', [
            'allUsers' => $allUsers,
        ]);
    }

    public function newUser() {
        echo $this->twig->render('new_user.twig');
    }

    public function editUser($idUser) {
        try {
            $singleUser = $this->userDAO->getSingleUser($idUser);
            foreach ($singleUser as $user) {
                $oneUser[] = new User($user);
            }
            echo $this->twig->render('edit_user.twig', [
                'oneUser' => $oneUser,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucun utilisateur identifié';
        }
    }

    public function alertUser($idUser) {
        try {
            $singleUser = $this->userDAO->getSingleUser($idUser);
            foreach ($singleUser as $user) {
                $oneUser[] = new User($user);
            }
            echo $this->twig->render('alert_user.twig', [
                'oneUser' => $oneUser,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucun utilisateur identifié';
        }
    }

    public function detailsUser($idUser) {
        try {
            $singleUser = $this->userDAO->getSingleUser($idUser);
            foreach ($singleUser as $user) {
                $oneUser[] = new User($user);
            }
            echo $this->twig->render('details_user.twig', [
                'oneUser' => $oneUser,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucun utilisateur identifié';
        }
    }
}