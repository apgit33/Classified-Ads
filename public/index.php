<?php

require dirname(dirname(__FILE__)). DIRECTORY_SEPARATOR . "vendor/autoload.php";
define('BASE_PATH','') ;//adrienp/www/public/annonce/public
define('SERVER_URI', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] .':' . $_SERVER['SERVER_PORT'] . BASE_PATH) ;

$router = new AltoRouter();
$router->setBasePath(BASE_PATH); 

// route principale -> index
$router->map('GET','/', function() {
    
    $twig = new \classified_ads\Twig('index.html.twig');

    $ads = \classified_ads\Ad::viewAll();

    echo $twig->_template->render([
        'list_ads' => $ads,
        'SERVER_URI'=> SERVER_URI
    ]);
});

// // route affichage annonce id
// $router->map('GET','/view-[i:id]', function($id) {

//     $twig = new \classified_ads\Twig('view.html.twig');

//     $ad = \classified_ads\Ad::view($id);

//     echo $twig->_template->render([
//         'ad' => $ad,
//         'SERVER_URI'=> SERVER_URI
//     ]);
// });

//route d'ajout annonce
$router->map('GET','/add_ad', function() {
    $twig = new \classified_ads\Twig('form.html.twig');
    $categoies = \classified_ads\Category::getAll();

    echo $twig->_template->render([
        'titre' => "Ajouter une annonce",
        'list_category'=> $categoies,
        'SERVER_URI'=> SERVER_URI
    ]);
});

//route d'edition d'une annonce
$router->map('GET','/edit-[*:slug]',function($slug) {
    $twig = new \classified_ads\Twig('form.html.twig');
    $categoies = \classified_ads\Category::getAll();

    $ads = \classified_ads\Ad::getAd($slug);
    echo $twig->_template->render([
        'list_ads'=> $ads,
        'list_category'=> $categoies,
        'SERVER_URI'=> SERVER_URI
    ]);
    // require "application/treatement/form.php";
});

//route form handler
$router->map('POST','/add_form', function() {
    require dirname(dirname(__FILE__))."/application/treatement/form.php";
});

//route confirmation annonce
$router->map('GET','/confirm-[*:slug]',function($slug){
    if(\classified_ads\Ad::validate($slug)){
        echo "validate";
    }else{
        echo "no validate";
    }
    header("Refresh:5; url=".SERVER_URI."");

});

//route suppression annonce
$router->map('GET','/delete-[*:slug]',function($slug){
    if(\classified_ads\Ad::delete($slug)){
        echo "deleted";
    }else{
        echo "no deleted";
    }
    header("Refresh:5; url=".SERVER_URI."");
});

// $router->map('GET','/test',function(){
//     // echo "test";
//     require dirname(dirname(__FILE__))."/application/template/home.php";
// });

$match = $router->match();

if($match != null) {
        call_user_func_array($match['target'],$match['params']);
} else {
    require dirname(dirname(__FILE__))."/application/template/404.php";
}