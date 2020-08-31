<?php

require dirname(dirname(__FILE__)). DIRECTORY_SEPARATOR . "vendor/autoload.php";

use classified_ads\Ad;
use classified_ads\User;
use \Respect\Validation\Validator as v;

$router = new AltoRouter();
$router->setBasePath(''); //adrienp/www/public/annonce

// route principale -> index
$router->map('GET','/', function() {
    
    $twig = new \classified_ads\Twig('index.html.twig');

    $datas = \classified_ads\Ad::viewAll();

    echo $twig->_template->render([
        'liste_annonce' => $datas
    ]);
});

// route affichage annonce id
$router->map('GET','/view-[i:id]', function($id) {

    $twig = new \classified_ads\Twig('view.html.twig');

    $datas = \classified_ads\Ad::view($id);

    echo $twig->_template->render([
        '' => $datas
    ]);
});

//route d'ajout annonce
$router->map('GET','/add_ad', function() {
    $twig = new \classified_ads\Twig('form.html.twig');
    // $datas = \classified_ads\Ad::affiche($id);

    echo $twig->_template->render([
        'titre' => "Ajouter une annonce",
    ]);
});

//route form handler
$router->map('POST','/add_form', function() {
    $erreur = [];
    $user = new User();
    
    //check email
    if (v::key('mail')->validate($_POST) && v::email()->validate($_POST['mail'])) {
        $user->mail = $_POST['mail'];
    } else {
        $erreur['mail'] = "Enter a valid email";
    }

    //check first name
    if(v::key('first_name')->validate($_POST) && v::alpha('-')->length(2,45)->validate($_POST['first_name'])){
        $user->firstName = $_POST['first_name'];
    } else {
        $erreur['first_name'] = "Enter a valid first name";
    }

    //check last name
    if(v::key('last_name')->validate($_POST) && v::alpha('-')->validate($_POST['last_name'])){
        $user->lastName = $_POST['last_name'];
    } else {
        $erreur['last_name'] = "Enter a valid last name";
    }

    //check phone

    //check price
    $price = $_POST['price'];

    if(v::key('price')->validate($_POST) && v::notEmpty()->validate($price) && !(v::numericVal()->positive()->validate($price)) ){
        $erreur['price'] = "Enter a valid price";
    }

    //check category
    $catId = $_POST['catId'];

    //check image
    if(v::key('image')->validate($_FILES) && v::notEmpty()->validate($_FILES['image_url']['name'])) {
        $extensions = array('jpg', 'jpeg', 'png');
        $extensionUpload_image = strtolower(substr(strrchr($_FILES['image_url']['name'], '.'), 1));

        if (!in_array($extensionUpload_image,$extensions)){
            $erreur['image'] = "Mauvaise extension de fichier";
        } else {
            if(move_uploaded_file($_FILES['ticket']['tmp_name'], "../medias/ticket_achat/$userId.$extensionUpload_image")){
                $image = "$userId.$extensionUpload_image";
            }
        }
    }

    //check desc
    if(v::key('desc')->validate($_POST) && v::length(5,255)->validate($_POST['desc'])) {
        $desc = $_POST['desc'];
    } else {
        $erreur['desc'] = "Enter a valid desc";
    }

    //check captcha.
    // your secret key
    $secret = "6LdUlLQZAAAAAB5aOeFWThZVnwlN4YFesXbdKu4n";
    // empty response
    $response = null;
    // check secret key
    $reCaptcha = new ReCaptcha($secret);

    // if submitted check response
    if ($_POST["g-recaptcha-response"]) {
        $response = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
        );
    }

    if ($response == null || ($response->success==false)) {
        $erreurs['captcha'] = 'Merci de cocher le captcha';
    }


    if(empty($erreur)) {
        $user->checkUser();
        $uniqueId = random_bytes(60);
        $imageName ="test";
        $ad = new Ad($desc,$image,$imageName,$uniqueId,$catId,$user->id);

        Ad::add($ad);
        //envoi mail de confirmation
        $sujet = "Validation de votre annonce";
        $message = "http://annonce/confirm-".$ad->uniqid."\n edition: http://annonce/edit-".$ad->uniqid;
        mail($user->mail, $sujet,$message);
    }
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
    require "application/template/404.php";
}