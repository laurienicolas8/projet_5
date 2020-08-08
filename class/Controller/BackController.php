<?php 

namespace App\Controller;

use Exception;
use App\Entity\Answer;
use App\Entity\Category;
use App\Controller\Controller;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Entity\User;

require('vendor/autoload.php');

class BackController extends Controller {
        
    /**
     * dashboard
     * check if an user is connected
     * fetch the session user_connected 
     * render the page dashboard 
     * @return void
     */
    public function dashboard() {
        // all the backController methods check if an user is connected, and render the loginPage if it isn't the case
        if (isset($_SESSION['user_connected'])) {
            $user = $_SESSION['user_connected'];
            echo $this->twig->render('dashboard.twig', [
                'user' => $user,
            ]);
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    //---------- ANSWERS ----------//    
    /**
     * validNewAnswer
     * check if an user is connected
     * call the method createAnswer in answerDAO 
     * @param  string $answer
     * @param  bool $rightAnswer
     * @param  int $idQuestion
     * @return void
     */
    public function validNewAnswer($answer, $rightAnswer, $idQuestion) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $this->answerDAO->createAnswer($answer, $rightAnswer, $idQuestion);
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de créer cette réponse';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * editAnswer
     * check if an user is connected
     * fetch the question and its answers
     * fetch the answer concerned to edit
     * create objects with controller methods
     * render the page details_question
     * @param  int $idAnswer
     * @param  int $idQuestion
     * @return void
     */
    public function editAnswer($idAnswer, $idQuestion) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $singleAnswer = $this->answerDAO->getSingleAnswer($idAnswer);
                $oneQuestion = $this->singleQuestionObject($idQuestion);
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
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * updateAnswer
     * check if an user is connected
     * call the method modifyAnswer in answerDAO
     * @param  int $idAnswer
     * @param  string $answer
     * @param  bool $rightAnswer
     * @return void
     */
    public function updateAnswer($idAnswer, $answer, $rightAnswer) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $this->answerDAO->modifyAnswer($idAnswer, $answer, $rightAnswer);
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de modifier cette réponse';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * deleteAnswer
     * check if an user is connected
     * call the method supprAnswer in answerDAO
     * @param  int $idAnswer
     * @return void
     */
    public function deleteAnswer($idAnswer) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $this->answerDAO->supprAnswer($idAnswer);
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de supprimer cette réponse';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }

    //---------- CATEGORIES ----------//    
    /**
     * categories
     * check if an user is connected
     * fetch all categories
     * create objects with controller methods
     * render the page categories
     * delete session variables alerts if they exist
     * @return void
     */
    public function categories() {
        if (isset($_SESSION['user_connected'])) {
            $allCategories = $this->allCategoriesObject();
            echo $this->twig->render('categories.twig', [
                'allCategories' => $allCategories, 
                'session' => $_SESSION,
            ]);
            if (isset($_SESSION['new_category'])) {
                unset($_SESSION['new_category']);
            }
            if (isset($_SESSION['delete_category'])) {
                unset($_SESSION['delete_category']);
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * detailsCategory
     * check if an user is connected
     * fetch the category concerned and its quiz
     * render the page details_category
     * delete session variables alerts if they exist
     * @param  int $idCategory
     * @return void
     */
    public function detailsCategory($idCategory) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $oneCategory = $this->singleCategoryObject($idCategory);
                $allQuiz = $this->quizByCategoryObject($idCategory);
                echo $this->twig->render('details_category.twig', [
                    'oneCategory' => $oneCategory,
                    'allQuiz' => $allQuiz,
                    'session' => $_SESSION,
                ]);
                if (isset($_SESSION['update_category'])) {
                    unset($_SESSION['update_category']);
                }
                if (isset($_SESSION['new_quiz'])) {
                    unset($_SESSION['new_quiz']);
                }
                if (isset($_SESSION['delete_quiz'])) {
                    unset($_SESSION['delete_quiz']);
                }
            } catch (Exception $e) {
                echo 'Erreur controller : Aucune catégorie identifiée';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * newCategory
     * check if an user is connected
     * render the page new_category
     * @return void
     */
    public function newCategory() {
        if (isset($_SESSION['user_connected'])) {
            echo $this->twig->render('new_category.twig');
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * validNewCategory
     * check if an user is connected
     * call the method createCategory in categoryDAO 
     * create a session variable to alert it's done
     * @param  string $nameCategory
     * @param  string $imageCategory
     * @return void
     */
    public function validNewCategory($nameCategory, $imageCategory) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $this->categoryDAO->createCategory($nameCategory, $imageCategory);
                $_SESSION['new_category'] = 'DONE';
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de créer cette catégorie';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * editCategory
     * check if an user is connected
     * fetch the category concerned 
     * create object with controller method
     * render the page edit_category
     * @param  int $idCategory
     * @return void
     */
    public function editCategory($idCategory) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $oneCategory = $this->singleCategoryObject($idCategory);
                echo $this->twig->render('edit_category.twig', [
                    'oneCategory' => $oneCategory,
                ]);
            } catch (Exception $e) {
                echo 'Erreur controller : Aucune catégorie identifiée';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * updateCategory
     * check if an user is connected
     * call the method modifyCategory in categoryDAO
     * create a session variable to alert it's done
     * @param  int $idCategory
     * @param  string $nameCategory
     * @param  string $imageCategory
     * @return void
     */
    public function updateCategory($idCategory, $nameCategory, $imageCategory) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $this->categoryDAO->modifyCategory($idCategory, $nameCategory, $imageCategory);
                $_SESSION['update_category'] = 'DONE';
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de modifier cette catégorie';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * alertCategory
     * check if an user is connected
     * fetch the category concerned 
     * create objects with controller method
     * render the page alert_category
     * @param  int $idCategory
     * @return void
     */
    public function alertCategory($idCategory) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $oneCategory = $this->singleCategoryObject($idCategory);
                echo $this->twig->render('alert_category.twig', [
                    'oneCategory' => $oneCategory,
                ]);
            } catch (Exception $e) {
                echo 'Erreur controller : Aucune catégorie identifiée';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * deleteCategory
     * check if an user is connected
     * call the method supprCategory in categoryDAO
     * create a session variable to alert it's done
     * @param  int $idCategory
     * @return void
     */
    public function deleteCategory($idCategory) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $this->categoryDAO->supprCategory($idCategory);
                $_SESSION['delete_category'] = 'DONE';
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de supprimer cette catégorie';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }

    //---------- QUIZ ----------//    
    /**
     * quiz
     * check if an user is connected
     * fetch all quiz
     * create objects
     * Delete duplications of category in quiz cards
     * render the page quiz
     * @param  int $currentPage
     * @return void
     */
    public function quiz($currentPage) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $quiz = $this->quizDAO->getAllQuiz($currentPage);
                foreach ($quiz as $oneQuiz) {
                    $quizCategory[] = $oneQuiz['idCategory'];
                    $allQuiz[] = new Quiz($oneQuiz);
                }
                // Delete duplications to avoid duplication in the category view
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
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * detailsQuiz
     * check if an user is connected
     * fetch the quiz concerned and its questions
     * create object with controller method
     * render the page details_quiz
     * delete the session variables alerts if they exists
     * @param  int $idQuiz
     * @return void
     */
    public function detailsQuiz($idQuiz) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $oneQuiz = $this->singleQuizObject($idQuiz);
                $allQuestions = $this->questionsObject($idQuiz);
                echo $this->twig->render('details_quiz.twig', [
                    'oneQuiz' => $oneQuiz,
                    'allQuestions' => $allQuestions,
                    'session' => $_SESSION,
                ]);
                if (isset($_SESSION['update_quiz'])) {
                    unset($_SESSION['update_quiz']);
                }
                if (isset($_SESSION['new_question'])) {
                    unset($_SESSION['new_question']);
                }
                if (isset($_SESSION['delete_question'])) {
                    unset($_SESSION['delete_question']);
                }
            } catch (Exception $e) {
                echo 'Erreur controller : Aucun quiz identifié';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * newQuiz
     * check if an user is connected
     * fetch all categories for input select
     * create objects with controller method
     * render the page new_quiz
     * @return void
     */
    public function newQuiz() {
        if (isset($_SESSION['user_connected'])) {
            $allCategories = $this->allCategoriesObject();
            echo $this->twig->render('new_quiz.twig', [
                'allCategories' => $allCategories,
            ]);
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * validNewQuiz
     * check if an user is connected
     * call the method createQuiz in quizDAO
     * create a session variable to alert it's done
     * @param  string $nameQuiz
     * @param  string $imageQuiz
     * @param  int $idCategory
     * @return void
     */
    public function validNewQuiz($nameQuiz, $imageQuiz, $idCategory) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $this->quizDAO->createQuiz($nameQuiz, $imageQuiz, $idCategory);
                $_SESSION['new_quiz'] = 'DONE';            
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de créer ce quiz';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * editQuiz
     * check if an user is connected
     * fetch the quiz concerned, its category and all categories for input select
     * create objects with controller methods
     * render the page edit_quiz
     * @param  int $idQuiz
     * @param  int $idCategory
     * @return void
     */
    public function editQuiz($idQuiz, $idCategory) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $oneQuiz = $this->singleQuizObject($idQuiz);
                $oneCategory = $this->singleCategoryObject($idCategory);
                $allCategories = $this->allCategoriesObject();
                echo $this->twig->render('edit_quiz.twig', [
                    'oneQuiz' => $oneQuiz,
                    'oneCategory' => $oneCategory,
                    'allCategories' => $allCategories,
                ]);
            } catch (Exception $e) {
                echo 'Erreur controller : Aucun quiz identifié';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * updateQuiz
     * check if an user is connected
     * call the method modifyQuiz in quizDAO
     * create a session variable to alert it's done
     * @param  int $idQuiz
     * @param  string $nameQuiz
     * @param  string $imageQuiz
     * @param  int $idCategory
     * @return void
     */
    public function updateQuiz($idQuiz, $nameQuiz, $imageQuiz, $idCategory) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $this->quizDAO->modifyQuiz($idQuiz, $nameQuiz, $imageQuiz, $idCategory);
                $_SESSION['update_quiz'] = 'DONE';
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de modifier ce quiz';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * alertQuiz
     * check if an user is connected
     * fetch the quiz concerned 
     * create object with controller method
     * @param  int $idQuiz
     * @return void
     */
    public function alertQuiz($idQuiz) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $oneQuiz = $this->singleQuizObject($idQuiz);
                echo $this->twig->render('alert_quiz.twig', [
                    'oneQuiz' => $oneQuiz,
                ]);
            } catch (Exception $e) {
                echo 'Erreur controller : Aucun quiz identifié';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * deleteQuiz
     * check if an user is connected
     * call the method supprQuiz in quizDAO
     * create a session variable to alert it's done
     * @param  int $idQuiz
     * @return void
     */
    public function deleteQuiz($idQuiz) {
        if (isset($_SESSION['user_connected'])) {
            try {   
                $this->quizDAO->supprQuiz($idQuiz);
                $_SESSION['delete_quiz'] = 'DONE';
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de supprimer ce quiz';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }

    //---------- QUESTION ----------//    
    /**
     * detailsQuestion
     * check if an user is connected
     * fetch the question concerned and its answers
     * create objects with controller methods
     * render the page details_question
     * delete the session variable update_question if it exists
     * @param  int $idQuestion
     * @return void
     */
    public function detailsQuestion($idQuestion) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $oneQuestion = $this->singleQuestionObject($idQuestion);
                $allAnswers = $this->answersObject($idQuestion);
                echo $this->twig->render('details_question.twig', [
                    'oneQuestion' => $oneQuestion,
                    'allAnswers' => $allAnswers,
                    'session' => $_SESSION,
                ]);
                if (isset($_SESSION['update_question'])) {
                    unset($_SESSION['update_question']);
                }
            } catch (Exception $e) {
                echo 'Erreur controller : Aucune question identifiée';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * newQuestion
     * check if an user is connected
     * fetch the quiz concerned by the new question
     * render the page new_question
     * @param  int $idQuiz
     * @return void
     */
    public function newQuestion($idQuiz) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $oneQuiz = $this->singleQuizObject($idQuiz);
                echo $this->twig->render('new_question.twig', [
                    'oneQuiz' => $oneQuiz,
                ]);
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de créer une nouvelle question sur ce quiz';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * validNewQuestion
     * check if an user is connected
     * call the method createQuestion in questionDAO
     * create a session variable to alert it's done
     * @param  string $question
     * @param  string $explanation
     * @param  int $idQuiz
     * @return void
     */
    public function validNewQuestion($question, $explanation, $idQuiz) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $this->questionDAO->createQuestion($question, $explanation, $idQuiz);
                $_SESSION['new_question'] = 'DONE';
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de créer cette question';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * editQuestion
     * check if an user is connected
     * fetch the question concerned
     * create object with controller method
     * render the page edit_question
     * @param  int $idQuestion
     * @return void
     */
    public function editQuestion($idQuestion) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $oneQuestion = $this->singleQuestionObject($idQuestion);
                echo $this->twig->render('edit_question.twig', [
                    'oneQuestion' => $oneQuestion,
                ]);
            } catch (Exception $e) {
                echo 'Erreur controller : Aucune question identifiée';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * updateQuestion
     * check if an user is connected
     * call the method modifyQuestion in questionDAO
     * create a session variable to alert it's done
     * @param  int $idQuestion
     * @param  string $question
     * @param  string $explanation
     * @return void
     */
    public function updateQuestion($idQuestion, $question, $explanation) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $this->questionDAO->modifyQuestion($idQuestion, $question, $explanation);
                $_SESSION['update_question'] = 'DONE';
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de modifier cette question';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * alertQuestion
     * check if an user is connected
     * fetch the question concerned
     * create object with controller method
     * render the page alert_question
     * @param  int $idQuestion
     * @return void
     */
    public function alertQuestion($idQuestion) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $oneQuestion = $this->singleQuestionObject($idQuestion);
                echo $this->twig->render('alert_question.twig', [
                    'oneQuestion' => $oneQuestion,
                ]);
            } catch (Exception $e) {
                echo 'Erreur controller : Aucune question identifiée';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * deleteQuestion
     * check if an user is connected
     * call the method supprQuestion in questionDAO
     * create a session variable to alert it's done
     * @param  int $idQuestion
     * @return void
     */
    public function deleteQuestion($idQuestion) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $this->questionDAO->supprQuestion($idQuestion);
                $_SESSION['delete_question'] = 'DONE';
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de supprimer cette question';
            }   
        } else {
            echo $this->twig->render('login.twig');
        }   
    }

    //---------- USER ----------//    
    /**
     * users
     * check if an user is connected
     * fetch all users 
     * create objects with controller method
     * render the page users
     * delete session variables alerts if they exist
     * @return void
     */
    public function users() {
        if (isset($_SESSION['user_connected'])) {
            $users = $this->userDAO->getAllUsers();
            // Create an empty variable to avoid an error of undefined variable
            if ($users === []) {
                $allUsers = null;
            } else {
                foreach ($users as $user) {
                    $allUsers[] = new User($user);
                }
            }
            echo $this->twig->render('users.twig', [
                'allUsers' => $allUsers,
                'session' => $_SESSION,
            ]);
            if (isset($_SESSION['new_user'])) {
                unset($_SESSION['new_user']);
            }
            if (isset($_SESSION['delete_user'])) {
                unset($_SESSION['delete_user']);
            }
        } else {
            echo $this->twig->render('login.twig');
        } 
    }
    
    /**
     * detailsUser
     * check if an user is connected
     * fetch the user concerned
     * create object with controller method
     * render the page details_user
     * delete the session variable update_user if it exists
     * @param  int $idUser
     * @return void
     */
    public function detailsUser($idUser) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $oneUser = $this->singleUserObject($idUser);
                echo $this->twig->render('details_user.twig', [
                    'oneUser' => $oneUser,
                    'session' => $_SESSION,
                ]);
                if (isset($_SESSION['update_user'])) {
                    unset($_SESSION['update_user']);
                }
            } catch (Exception $e) {
                echo 'Erreur controller : Aucun utilisateur identifié';
            }
        } else {
            echo $this->twig->render('login.twig');
        } 
    }
    
    /**
     * newUser
     * check if an user is connected
     * render the page new_user
     * @return void
     */
    public function newUser() {
        if (isset($_SESSION['user_connected'])) {
            echo $this->twig->render('new_user.twig');
        } else {
            echo $this->twig->render('login.twig');
        } 
    }
    
    /**
     * validNewUser
     * check if an user is connected
     * fetch all users
     * create objects
     * check if the identifiant is not used already
     * hash the password
     * call the method createUser in userDAO
     * create a session variable to alert it's done
     * @param  string $identifiant
     * @param  string $password
     * @param  string $nameUser
     * @param  string $lastnameUser
     * @param  bool $admin
     * @return void
     */
    public function validNewUser($identifiant, $password, $nameUser, $lastnameUser, $admin) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $users = $this->userDAO->getAllUsers();
                foreach ($users as $user) {
                    $allUsers[] = new User($user);
                }
                foreach ($allUsers as $user) {
                    $allIdentifiants[] = $user->identifiant();
                }
                // I check that the typed identifiant isn't already used
                if (array_search($identifiant, $allIdentifiants)) {
                    $_SESSION['error_identifiant'] = 'Une erreur est survenue : L\'utilisateur n\'a pas pu être créé car l\'identifiant saisi est déjà utilisé par un autre utilisateur. Veuillez réessayer.';
                } else {
                    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
                    $this->userDAO->createUser($identifiant, $passwordHashed, $nameUser, $lastnameUser, $admin);
                    $_SESSION['new_user'] = 'DONE';
                }
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de créer cet utilisateur';
            }
        } else {
            echo $this->twig->render('login.twig');
        } 
    }
    
    /**
     * editUser
     * check if an user is connected
     * fetch the user concerned
     * create object with controller method
     * render the page edit_user
     * @param  int $idUser
     * @return void
     */
    public function editUser($idUser) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $oneUser = $this->singleUserObject($idUser);
                echo $this->twig->render('edit_user.twig', [
                    'oneUser' => $oneUser,
                ]);
            } catch (Exception $e) {
                echo 'Erreur controller : Aucun utilisateur identifié';
            }
        } else {
            echo $this->twig->render('login.twig');
        } 
    }
    
    /**
     * updateUser
     * check if an user is connected
     * hash the password
     * call the medtho modifyUser in userDAO
     * create a session variable to alert it's done
     * @param  int $idUser
     * @param  string $identifiant
     * @param  string $password
     * @param  string $nameUser
     * @param  string $lastnameUser
     * @param  bool $admin
     * @return void
     */
    public function updateUser($idUser, $identifiant, $password, $nameUser, $lastnameUser, $admin) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
                $this->userDAO->modifyUser($idUser, $identifiant, $passwordHashed, $nameUser, $lastnameUser, $admin);
                $_SESSION['update_user'] = 'DONE';
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de modifier cet utilisateur';
            }
        } else {
            echo $this->twig->render('login.twig');
        } 
    }
    
    /**
     * alertUser
     * fetch the user concerned
     * create object with controller method
     * render the page alert_user
     * @param  int $idUser
     * @return void
     */
    public function alertUser($idUser) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $oneUser = $this->singleUserObject($idUser);
                echo $this->twig->render('alert_user.twig', [
                    'oneUser' => $oneUser,
                ]);
            } catch (Exception $e) {
                echo 'Erreur controller : Aucun utilisateur identifié';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
    
    /**
     * deleteUser
     * check if an user is connected
     * call the method supprUser in userDAO
     * create a session variable to alert it's done
     * @param  int $idUser
     * @return void
     */
    public function deleteUser($idUser) {
        if (isset($_SESSION['user_connected'])) {
            try {
                $this->userDAO->supprUser($idUser);
                $_SESSION['delete_user'] = 'DONE';
            } catch (Exception $e) {
                echo 'Erreur controller : Impossible de supprimer cet utilisateur';
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }
}