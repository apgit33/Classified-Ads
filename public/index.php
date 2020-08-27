<?php

require dirname(dirname(__FILE__)). DIRECTORY_SEPARATOR . "vendor/autoload.php";


$router = new AltoRouter();
$router->setBasePath(''); //adrienp/www/public/annonce

// route principale -> index
$router->map('GET','/', function() {
    
    $twig = new \classified_ads\Twig('index.html.twig');

    $datas = \classified_ads\Ad::afficheAll();

    echo $twig->_template->render([
        '' => $datas
    ]);
});

// route affichage annonce id
$router->map('GET','/view-[i:id]', function($id) {

    $twig = new \classified_ads\Twig('view.html.twig');

    $datas = \classified_ads\Ad::affiche($id);

    echo $twig->_template->render([
        '' => $datas
    ]);
});

//route d'ajout annonce
$router->map('GET','/add_ad', function() {
    echo "test"; // \classified_ads\Ad::add();
});


$match = $router->match();

if($match != null) {
        call_user_func_array($match['target'],$match['params']);
} else {
    require "application/template/404.php";
}