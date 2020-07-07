<?php

use App\Controller\BackController;
use App\Controller\FrontController;

require('vendor/autoload.php');

$router = new AltoRouter();
$frontController = new FrontController();
$backController = new BackController();

// Itinéraires
// FRONT
$router->map('GET', '/', $frontController->home());
$router->map('GET', '/all_categories', $frontController->allCategories());
$router->map('GET', '/all_quiz', $frontController->allQuiz());
$router->map('GET', '/single_category/[i:id]', $frontController->singleCategory($idCategory)); //param
$router->map('GET', '/start_quiz/[i:id]', $frontController->startQuiz($idQuiz)); //param
$router->map('GET', '/quiz/[i:id]', $frontController->showQuizQuestions($idQuiz)); //param

//BACK

// Trouver une correspondance entre l'URL reçue et les itinéraires
$match = $router->match();

if ($match !==null) {
    if (is_callable($match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    } 
}
