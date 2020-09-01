<?php

require dirname(dirname(__FILE__)). DIRECTORY_SEPARATOR . "vendor/autoload.php";
define('BASE_PATH','') ;//adrienp/www/public/annonce/public
define('SERVER_URI', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] .':' . $_SERVER['SERVER_PORT'] . BASE_PATH) ;
// use classified_ads\Ad;
// use classified_ads\User;
// use \Respect\Validation\Validator as v;

$router = new AltoRouter();
$router->setBasePath(BASE_PATH); 

// route principale -> index
$router->map('GET','/', function() {
    
    $twig = new \classified_ads\Twig('index.html.twig');

    $datas = \classified_ads\Ad::viewAll();

    echo $twig->_template->render([
        'liste_annonce' => $datas,
        'SERVER_URI'=> SERVER_URI
    ]);
});

// route affichage annonce id
$router->map('GET','/view-[i:id]', function($id) {

    $twig = new \classified_ads\Twig('view.html.twig');

    $datas = \classified_ads\Ad::view($id);

    echo $twig->_template->render([
        '' => $datas,
        'SERVER_URI'=> SERVER_URI
    ]);
});

//route d'ajout annonce
$router->map('GET','/add_ad', function() {
    $twig = new \classified_ads\Twig('form.html.twig');
    // $datas = \classified_ads\Ad::affiche($id);

    echo $twig->_template->render([
        'titre' => "Ajouter une annonce",
        'SERVER_URI'=> SERVER_URI
    ]);
});

//route form handler
$router->map('POST','/add_form', function() {
    include "application/treatement/form.php";
});

//route confirmation annonce
$router->map('GET','/confirm-[slug:slug]',function($slug){
    \classified_ads\Ad::validate($slug);
    // \classified_ads\User::confirmed($slug);
});


$match = $router->match();

if($match != null) {
        call_user_func_array($match['target'],$match['params']);
} else {
    // require "application/template/404.php";
    echo SERVER_URI;
}