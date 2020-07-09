<?php

use App\Controller\BackController;
use App\Controller\FrontController;

require('vendor/autoload.php');

$router = new AltoRouter();
$router->setBasePath('/projet_5');
$frontController = new FrontController;
$backController = new BackController;

// Itinéraires
// FRONT
$router->addRoutes(array(
    array('GET', '/', $frontController->home(), 'home'),
    array('GET', '/all_quiz', $frontController->allQuiz(), 'all_quiz')
  ));
//$router->map('GET', '/', $frontController->home(), 'home');
//$router->map('GET', '/all_quiz', $frontController->allQuiz(), 'all_quiz');

/*$router->map('GET', '/single_category/[i:id]', $frontController->singleCategory($id));
$router->map('GET', '/start_quiz/[i:id]', $frontController->startQuiz($id)); 
$router->map('GET', '/quiz/[i:id]', $frontController->showQuizQuestions($id));*/

//BACK


// Trouver une correspondance entre l'URL reçue et les itinéraires
$match = $router->match();
dump($match);

if ($match !==null) {
    if (is_callable($match['target'])) {
        //call_user_func_array($match['target'], $match['params']);
    } 
}
