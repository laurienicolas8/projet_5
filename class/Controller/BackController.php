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
            echo 'Erreur controller : Impossible de créer cette réponse';
        }
    }

    public function editAnswer($idAnswer, $idQuestion) {
        try {
            $singleAnswer = $this->answerDAO->getSingleAnswer($idAnswer);
            $oneQuestion = $this->singleQuestion($idQuestion);
            $answers = $this->answerDAO->getQuestionAnswers($idQuestion);
            foreach ($singleAnswer as $answer) {
                $oneAnswer[] = new Answer($answer);
            }
            foreach ($answers as $answer) {
                $allAnswers[] = new Answer($answer);
            }
            echo $this->twig->render('details_question.twig', [
                'oneQuestion' => $oneQuestion,
                'allAnswers' => $allAnswers,
                'oneAnswer' => $oneAnswer,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de modifier cette réponse';
        }
    }

    public function updateAnswer($idAnswer, $answer, $rightAnswer) {
        try {
            $this->answerDAO->modifyAnswer($idAnswer, $answer, $rightAnswer);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de modifier cette réponse';
        }
    }

    public function deleteAnswer($idAnswer) {
        try {
            $this->answerDAO->supprAnswer($idAnswer);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de supprimer cette réponse';
        }
    }

    //---------- CATEGORIES ----------//
    public function categories() {
        $allCategories = $this->allCategories();
        echo $this->twig->render('categories.twig', [
            'allCategories' => $allCategories, 
        ]);
    }

    public function detailsCategory($idCategory) {
        try {
            $oneCategory = $this->singleCategory($idCategory);
            $allQuiz = $this->quizByCategory($idCategory);
            echo $this->twig->render('details_category.twig', [
                'oneCategory' => $oneCategory,
                'allQuiz' => $allQuiz,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucune catégorie identifiée';
        }
    }

    public function newCategory() {
        echo $this->twig->render('new_category.twig');
    }

    public function validNewCategory($nameCategory, $imageCategory) {
        try {
            $this->categoryDAO->createCategory($nameCategory, $imageCategory);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de créer cette catégorie';
        }
    }

    public function editCategory($idCategory) {
        try {
            $oneCategory = $this->singleCategory($idCategory);
            echo $this->twig->render('edit_category.twig', [
                'oneCategory' => $oneCategory,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucune catégorie identifiée';
        }
    }

    public function updateCategory($idCategory, $nameCategory, $imageCategory) {
        try {
            $this->categoryDAO->modifyCategory($idCategory, $nameCategory, $imageCategory);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de modifier cette catégorie';
        }
    }

    public function alertCategory($idCategory) {
        try {
            $oneCategory = $this->singleCategory($idCategory);
            echo $this->twig->render('alert_category.twig', [
                'oneCategory' => $oneCategory,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucune catégorie identifiée';
        }
    }

    public function deleteCategory($idCategory) {
        try {
            $this->categoryDAO->supprCategory($idCategory);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de supprimer cette catégorie';
        }
    }

    //---------- QUIZ ----------//
    public function quiz($currentPage) {
        try {
            $quiz = $this->quizDAO->getAllQuiz($currentPage);
            foreach ($quiz as $oneQuiz) {
                $quizCategory[] = $oneQuiz['idCategory'];
                $allQuiz[] = new Quiz($oneQuiz);
            }
            // Supprimer les doublons pour éviter les doublons de catégorie dans la view
            $quizUnique = array_unique($quizCategory);
            foreach ($quizUnique as $quiz) {
                $singleCategory = $this->categoryDAO->getSingleCategory($quiz);
                foreach ($singleCategory as $category) {
                    $oneCategory[] = new Category($category);
                }
            }
            echo $this->twig->render('quiz.twig', [
                'allQuiz' => $allQuiz,
                'oneCategory' => $oneCategory,
                'nbPages' => $this->quizDAO->nbPages,
                'currentPage' => $currentPage,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : La numéro de la page est inconnu';
        }
    }

    public function detailsQuiz($idQuiz) {
        try {
            $oneQuiz = $this->singleQuiz($idQuiz);
            $allQuestions = $this->questions($idQuiz);
            echo $this->twig->render('details_quiz.twig', [
                'oneQuiz' => $oneQuiz,
                'allQuestions' => $allQuestions,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun quiz identifié';
        }
    }

    public function newQuiz() {
        $allCategories = $this->allCategories();
        echo $this->twig->render('new_quiz.twig', [
            'allCategories' => $allCategories,
        ]);
    }

    public function validNewQuiz($nameQuiz, $imageQuiz, $idCategory) {
        try {
            $this->quizDAO->createQuiz($nameQuiz, $imageQuiz, $idCategory);            
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de créer ce quiz';
        }
    }

    public function editQuiz($idQuiz) {
        try {
            $oneQuiz = $this->singleQuiz($idQuiz);
            $allCategories = $this->allCategories();
            echo $this->twig->render('edit_quiz.twig', [
                'oneQuiz' => $oneQuiz,
                'allCategories' => $allCategories,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun quiz identifié';
        }
    }

    public function updateQuiz($idQuiz, $nameQuiz, $imageQuiz, $idCategory) {
        try {
            $this->quizDAO->modifyQuiz($idQuiz, $nameQuiz, $imageQuiz, $idCategory);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de modifier ce quiz';
        }
    }

    public function alertQuiz($idQuiz) {
        try {
            $oneQuiz = $this->singleQuiz($idQuiz);
            echo $this->twig->render('alert_quiz.twig', [
                'oneQuiz' => $oneQuiz,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun quiz identifié';
        }
    }

    public function deleteQuiz($idQuiz) {
        try {   
            $this->quizDAO->supprQuiz($idQuiz);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de supprimer ce quiz';
        }
    }

    //---------- QUESTION ----------//
    public function detailsQuestion($idQuestion) {
        try {
            $oneQuestion = $this->singleQuestion($idQuestion);
            $allAnswers = $this->answers($idQuestion);
            echo $this->twig->render('details_question.twig', [
                'oneQuestion' => $oneQuestion,
                'allAnswers' => $allAnswers,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucune question identifiée';
        }
    }

    public function newQuestion($idQuiz) {
        try {
            $oneQuiz = $this->singleQuiz($idQuiz);
            echo $this->twig->render('new_question.twig', [
                'oneQuiz' => $oneQuiz,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de créer une nouvelle question sur ce quiz';
        }
    }

    public function validNewQuestion($question, $explanation, $idQuiz) {
        try {
            $this->questionDAO->createQuestion($question, $explanation, $idQuiz);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de créer cette question';
        }
    }

    public function editQuestion($idQuestion) {
        try {
            $oneQuestion = $this->singleQuestion($idQuestion);
            echo $this->twig->render('edit_question.twig', [
                'oneQuestion' => $oneQuestion,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucune question identifiée';
        }
    }

    public function updateQuestion($idQuestion, $question, $explanation) {
        try {
            $this->questionDAO->modifyQuestion($idQuestion, $question, $explanation);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de modifier cette question';
        }
    }

    public function alertQuestion($idQuestion) {
        try {
            $oneQuestion = $this->singleQuestion($idQuestion);
            echo $this->twig->render('alert_question.twig', [
                'oneQuestion' => $oneQuestion,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucune question identifiée';
        }
    }

    public function deleteQuestion($idQuestion) {
        try {
            $this->questionDAO->supprQuestion($idQuestion);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de supprimer cette question';
        }      
    }

    //---------- USER ----------//
    public function users() {
        $users = $this->userDAO->getAllUsers();
        if ($users === []) {
            $allUsers = null;
        } else {
            foreach ($users as $user) {
                $allUsers[] = new User($user);
            }
        }
        echo $this->twig->render('users.twig', [
            'allUsers' => $allUsers,
        ]);
    }

    public function detailsUser($idUser) {
        try {
            $oneUser = $this->singleUser($idUser);
            echo $this->twig->render('details_user.twig', [
                'oneUser' => $oneUser,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun utilisateur identifié';
        }
    }

    public function newUser() {
        echo $this->twig->render('new_user.twig');
    }

    public function validNewUser($identifiant, $password, $nameUser, $lastnameUser, $admin) {
        try {
            $this->userDAO->createUser($identifiant, $password, $nameUser, $lastnameUser, $admin);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de créer cet utilisateur';
        }
    }

    public function editUser($idUser) {
        try {
            $oneUser = $this->singleUser($idUser);
            echo $this->twig->render('edit_user.twig', [
                'oneUser' => $oneUser,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun utilisateur identifié';
        }
    }

    public function updateUser($idUser, $identifiant, $password, $nameUser, $lastnameUser, $admin) {
        try {
            $this->userDAO->modifyUser($idUser, $identifiant, $password, $nameUser, $lastnameUser, $admin);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de modifier cet utilisateur';
        }
    }

    public function alertUser($idUser) {
        try {
            $oneUser = $this->singleUser($iduser);
            echo $this->twig->render('alert_user.twig', [
                'oneUser' => $oneUser,
            ]);
        } catch (Exception $e) {
            echo 'Erreur controller : Aucun utilisateur identifié';
        }
    }

    public function deleteUser($idUser) {
        try {
            $this->userDAO->supprUser($idUser);
        } catch (Exception $e) {
            echo 'Erreur controller : Impossible de supprimer cet utilisateur';
        }
    }
}