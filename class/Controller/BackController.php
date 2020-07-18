<?php 
namespace App\Controller;

use Exception;
use App\Entity\Quiz;
use App\Entity\User;
use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use App\Controller\Controller;

require('vendor/autoload.php');


class BackController extends Controller {
    
    public function dashboard() {
        echo $this->twig->render('dashboard.twig');
    }
    //---------- ANSWERS ----------//
    public function validNewAnswer($answer, $rightAnswer, $idQuestion) {
        try {
            $this->answerDAO->createAnswer($answer, $rightAnswer, $idQuestion);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de créer cette réponse';
        }
    }

    public function updateAnswer($idAnswer, $answer, $rightAnswer, $idQuestion) {
        try {
            $this->answerDAO->modifyAnswer($idAnswer, $answer, $rightAnswer, $idQuestion);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de modifier cette réponse';
        }
    }

    public function deleteAnswer($idAnswer) {
        try {
            $this->answerDAO->supprAnswer($idAnswer);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de supprimer cette réponse';
        }
    }

    //---------- CATEGORIES ----------//
    public function categories() {
        $categories = $this->categoryDAO->getAllCategories();
        foreach ($categories as $category) {
            $allCategories[] = new Category($category);
        }
        echo $this->twig->render('categories.twig', [
            'allCategories' => $allCategories, 
        ]);
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

    public function newCategory() {
        echo $this->twig->render('new_category.twig');
    }

    public function validNewCategory($nameCategory, $imageCategory) {
        try {
            $this->categoryDAO->createCategory($nameCategory, $imageCategory);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de créer cette catégorie';
        }
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

    public function updateCategory($idCategory, $nameCategory, $imageCategory) {
        try {
            $this->categoryDAO->modifyCategory($idCategory, $nameCategory, $imageCategory);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de modifier cette catégorie';
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

    public function deleteCategory($idCategory) {
        try {
            $this->categoryDAO->supprCategory($idCategory);
            $categories = $this->categoryDAO->getAllCategories();
            foreach ($categories as $category) {
                $allCategories[] = new Category($category);
            }
            echo $this->twig->render('categories.twig', [
                'allCategories' => $allCategories, 
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de supprimer cette catégorie';
        }
    }

    //---------- QUIZ ----------//
    public function quiz($currentPage) {
        $quiz = $this->quizDAO->getAllQuiz($currentPage);
        foreach ($quiz as $oneQuiz) {
            $allQuiz[] = new Quiz($oneQuiz);
        }
        echo $this->twig->render('quiz.twig', [
            'allQuiz' => $allQuiz,
            'nbPages' => $this->quizDAO->nbPages,
            'currentPage' => $currentPage,
        ]);
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

    public function newQuiz() {
        $categories = $this->categoryDAO->getAllCategories();
        foreach ($categories as $category) {
            $allCategories[] = new Category($category);
        }
        echo $this->twig->render('new_quiz.twig', [
            'allCategories' => $allCategories,
        ]);
    }

    public function validNewQuiz($nameQuiz, $imageQuiz, $idCategory) {
        try {
            $this->quizDAO->createQuiz($nameQuiz, $imageQuiz, $idCategory);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de créer ce quiz';
        }
    }

    public function editQuiz($idQuiz) {
        try {
            $singleQuiz = $this->quizDAO->getSingleQuiz($idQuiz);
            $categories = $this->categoryDAO->getAllCategories();
            foreach ($singleQuiz as $quiz) {
                $oneQuiz[] = new Quiz($quiz);
            }
            foreach ($categories as $category) {
                $allCategories[] = new Category($category);
            }
            echo $this->twig->render('edit_quiz.twig', [
                'oneQuiz' => $oneQuiz,
                'allCategories' => $allCategories,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucun quiz identifié';
        }
    }

    public function updateQuiz($idQuiz, $nameQuiz, $imageQuiz, $idCategory) {
        try {
            $this->quizDAO->modifyQuiz($idQuiz, $nameQuiz, $imageQuiz, $idCategory);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de modifier ce quiz';
        }
    }

    public function alertQuiz($idQuiz) {
        try {
            $singleQuiz = $this->quizDAO->getSingleQuiz($idQuiz);
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

    public function deleteQuiz($idQuiz) {
        try {   
            $this->quizDAO->supprQuiz($idQuiz);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de supprimer ce quiz';
        }
    }

    //---------- QUESTION ----------//
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

    public function newQuestion() {
        echo $this->twig->render('new_question.twig');
    }

    public function validNewQuestion($question, $explanation, $idQuiz) {
        try {
            $this->questionDAO->createQuestion($question, $explanation, $idQuiz);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de créer cette question';
        }
    }

    public function editQuestion($idQuestion) {
        try {
            $singleQuestion = $this->questionDAO->getSingleQuestion($idQuestion);
            foreach ($singleQuestion as $question) {
                $oneQuestion[] = new Question($question);
            }
            echo $this->twig->render('edit_question.twig', [
                'oneQuestion' => $oneQuestion,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucune question identifiée';
        }
    }

    public function updateQuestion($idQuestion, $question, $explanation, $idQuiz) {
        try {
            $this->questionDAO->modifyQuestion($idQuestion, $question, $explanation, $idQuiz);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de modifier cette question';
        }
    }

    public function alertQuestion($idQuestion) {
        try {
            $singleQuestion = $this->questionDAO->getSingleQuestion($idQuestion);
            foreach ($singleQuestion as $question) {
                $oneQuestion[] = new Question($question);
            }
            echo $this->twig->render('alert_question.twig', [
                'oneQuestion' => $oneQuestion,
            ]);
        } catch (Exception $e) {
            echo 'Erreur : Aucune question identifiée';
        }
    }

    public function deleteQuestion($idQuestion) {
        try {
            $this->questionDAO->supprQuestion($idQuestion);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de supprimer cette question';
        }      
    }

    //---------- USER ----------//
    public function users() {
        $users = $this->userDAO->getAllUsers();
        foreach ($users as $user) {
            $allUsers[] = new User($user);
        }
        echo $this->twig->render('users.twig', [
            'allUsers' => $allUsers,
        ]);
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

    public function newUser() {
        echo $this->twig->render('new_user.twig');
    }

    public function validNewUser($identifiant, $password, $nameUser, $lastnameUser, $admin) {
        try {
            $this->userDAO->createUser($identifiant, $password, $nameUser, $lastnameUser, $admin);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de créer cet utilisateur';
        }
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

    public function updateUser($idUser, $identifiant, $password, $nameUser, $lastnameUser, $admin) {
        try {
            $this->userDAO->modifyUser($idUser, $identifiant, $password, $nameUser, $lastnameUser, $admin);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de modifier cet utilisateur';
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

    public function deleteUser($idUser) {
        try {
            $this->userDAO->supprUser($idUser);
        } catch (Exception $e) {
            echo 'Erreur : Impossible de supprimer cet utilisateur';
        }
    }
}