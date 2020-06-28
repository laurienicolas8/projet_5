<?php
namespace projet_5\Router;

require('./vendor/autoload.php');

$router = new Altorouter();

// Itinéraires
$router->map('GET', '/', 'home');
$router->map('GET', '/all-categories', 'allCategories');
$router->map('GET', '/all-quiz', 'allQuiz');
$router->map('GET', '/category/[i:id]', 'category');
$router->map('GET', '/start-quiz/[i:id]', 'start-quiz');

// Trouver une correspondance entre l'URL reçue et les itinéraires
$match = $router->match();

if ($match !==null) {
    
}