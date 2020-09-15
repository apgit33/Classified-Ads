<?php

require dirname(dirname(__FILE__)). DIRECTORY_SEPARATOR . "vendor/autoload.php";
define('BASE_PATH','') ;//adrienp/www/public/annonce/public
define('SERVER_URI', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] .':' . $_SERVER['SERVER_PORT'] . BASE_PATH) ;

$router = new AltoRouter();
$router->setBasePath(BASE_PATH); 

// route principale -> index
$router->map('GET','/', function() {
    \classified_ads\Twig::index();
});

//route d'ajout annonce
$router->map('GET','/add_ad', function() {
    \classified_ads\Twig::viewForm();
});

//route d'edition d'une annonce
$router->map('GET','/edit-[*:slug]',function($slug) {
    \classified_ads\Twig::editForm($slug);
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

$match = $router->match();

if($match != null) {
        call_user_func_array($match['target'],$match['params']);
} else {
    require dirname(dirname(__FILE__))."/application/template/404.php";
}