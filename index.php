<?php
namespace Router;

require 'vendor/autoload.php';
use \FrontController;

$router = new \AltoRouter();
$frontController = new FrontController();


// Itinéraires
// FRONT
$router->map('GET', '/', $frontController->home());
$router->map('GET', '/all-categories', 'allCategories');
$router->map('GET', '/all-quiz', 'allQuiz');
$router->map('GET', '/category/[i:id]', 'category');
$router->map('GET', '/start-quiz/[i:id]', 'startQuiz');

//BACK


// Trouver une correspondance entre l'URL reçue et les itinéraires
$match = $router->match();

if ($match !==null) {
    if (is_callable($match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    } 
}