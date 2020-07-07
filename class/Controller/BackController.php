<?php 
namespace App\Controller;

use Exception;
use App\Controller\Controller;

require('vendor/autoload.php');


class BackController extends Controller {
    
    public function dashboard() {

    }

    public function creation() {

    }

    public function editCategory() {

    }

    public function newCategory($nameCategory, $imageCategory) {
        try {

        } catch (Exception $e) {

        }
    }

    public function editQuiz() {

    }

    public function newQuiz($nameQuiz, $imageQuiz, $idCategory) {
        try {

        } catch (Exception $e) {

        }
    }

    public function newQuestion($question, $explanation) {
        try {

        } catch (Exception $e) {

        }
    }

    public function newAnswer($answer, $rightAnswer, $idQuestion) {
        try {

        } catch (Exception $e) {

        }
    }

    public function modification() {

    }

    public function whichCategoryUpdate() {

    }

    public function accessUpdateCategory($idCategory) {
        try {

        } catch (Exception $e) {

        }
    }

    public function updateCategory($nameCategory, $imageCategory) {
        try {

        } catch (Exception $e) {

        }
    }

    public function whichQuizUpdate() {

    }

    public function accessUpdateQuiz($idQuiz) {
        try {

        } catch (Exception $e) {

        }
    }

    public function updateQuiz($nameQuiz, $imageQuiz, $idCategory) {
        try {

        } catch (Exception $e) {

        }
    }

    public function updateQuestion($question, $explanation) {
        try {

        } catch (Exception $e) {

        }
    }

    public function updateAnswer($answer, $rightAnswer, $idQuestion) {
        try {

        } catch (Exception $e) {

        }
    }

    public function suppression() {

    }

    public function whichCategoryDelete() {

    }

    public function deleteCategory($idCategory) {
        try {

        } catch (Exception $e) {

        }
    }

    public function whichQuizDelete() {

    }

    public function deleteQuiz($idQuiz) {
        try {

        } catch (Exception $e) {

        }
    }

    public function deleteQuestion($idQuestion) {
        try {

        } catch (Exception $e) {

        }
    }

    public function deleteAnswer($idAnswer) {
        try {

        } catch (Exception $e) {

        }
    }

    public function infoUser($idUser) {
        try {

        } catch (Exception $e) {

        }
    }

    public function editUser() {

    }

    public function newUser($nameUser, $password, $admin) {
        try {

        } catch (Exception $e) {

        }
    }

    public function whichUserUpdate() {

    }

    public function updateUser($nameUser, $password, $admin) {
        try {

        } catch (Exception $e) {

        }
    }

    public function whichUserDelete() {

    }

    public function deleteUser($idUser) {
        try {

        } catch (Exception $e) {

        }
    }
}