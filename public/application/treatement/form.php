<?php
// require dirname(dirname(__FILE__)). DIRECTORY_SEPARATOR . "vendor/autoload.php";

// namespace classified_ads\treatement;

// use classified_ads\Ad;
// require_once "application/class/recaptchalib.php";
use \Respect\Validation\Validator as v;

$erreur = [];
$new_category="";
$extensionUpload_image = "";

$user = new \classified_ads\User();
$ad = new \classified_ads\Ad();

//check email
if (v::key('mail')->validate($_POST) && v::email()->validate($_POST['mail'])) {
    $user->mail = $_POST['mail'];
} else {
    $erreur['mail'] = "Please verify ur email";
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
if(v::key('phone')->validate($_POST) && v::phone()->validate($_POST['phone'])) {
    $user->phone = $_POST['phone'];
} else {
    $erreur['phone'] = "Invalid phone number";
}

//check price
$ad->price = "";

if(v::key('price')->validate($_POST) && v::notEmpty()->validate($_POST['price']) && !(v::numericVal()->positive()->validate($_POST['price'])) ){
    $erreur['price'] = "Enter a valid price";
} else {
    $ad->price = $_POST['price'];
}

//check category
if(v::key('category')->validate($_POST) && v::digit()->validate($_POST['category'])){
    $ad->catId = $_POST['category'];
    // if (v::key('new_category')->validate($_POST) && v::alpha()->validate($_POST['new_category'])) {
    //     //on check la nouvelle catégory dans la bdd
    //     $query = "SELECT c_id FROM ca_category WHERE c_name = :cname";
    //     $data = \classified_ads\Bdd::executeSql($query,[':cname'=>$_POST['new_category']],[':cname'=>PDO::PARAM_STR]);
    //     if($data->fetch(PDO::FETCH_ASSOC)){
    //         $erreur['category'] = "Category already exist";
    //     } else {
    //         $new_category =  $_POST['new_category'];
    //     }
    // }
} else{
    $erreur['category'] = "invalid category";
}

// //check image name
// if(v::key('img_name')->validate($_POST) && v::alpha(' ')->validate($_POST['img_name'])) {
//     $ad->imgName = $_POST['img_name'];
// } else {
//     $erreur['img_name'] = "Name incorrect";
// }

//check image
if(v::key('img_url')->validate($_FILES) && v::notEmpty()->validate($_FILES['img_url']['name'])) {
    $extensions = array('jpg', 'jpeg', 'png');
    $extensionUpload_image = strtolower(substr(strrchr($_FILES['img_url']['name'], '.'), 1));

    if (!in_array($extensionUpload_image,$extensions)){
        $erreur['image'] = "Mauvaise extension de fichier";
    }
} else {
    $ad->imgUrl = "default.jpg";
}

//check desc
if(v::key('desc')->validate($_POST) && v::length(5,255)->validate($_POST['desc'])) {
    $ad->desc = $_POST['desc'];
} else {
    $erreur['desc'] = "Enter a valid desc";
}

// //check captcha.
// // your secret key
// $secret = "YourSecretKey";
// // empty response
// $response = null;
// // check secret key 
// $reCaptcha = new ReCaptcha($secret);

// // if submitted check response
// if ($_POST["g-recaptcha-response"]) {
//     $response = $reCaptcha->verifyResponse(
//         $_SERVER["REMOTE_ADDR"],
//         $_POST["g-recaptcha-response"]
//     );
// }

// if ($response == null || ($response->success==false)) {
//     $erreurs['captcha'] = 'Merci de cocher le captcha';
// }

/** 
 * Fin des tests
 */

if(empty($erreur)) {


    $user->checkUser();
    $ad->userId = $user->id;


    // //on insere la new_cat
    // if(v::notEmpty()->validate($new_category)) {
    //     $query = "INSERT INTO ca_category (c_name) VALUES (:name)";
    //     $co = \classified_ads\Bdd::connect();
    //     $sth = $co->prepare($query);
    //     $sth->bindParam(':name',$new_category,PDO::PARAM_STR);
    //     $sth->execute();
    //     $ad->catId = $co->lastInsertId();
    // }

    //on crée le repertoire de l'utilisateur s'il n'existe pas
    if(!file_exists("assets/medias/$user->id")) {
        mkdir("assets/medias/$user->id");
    }
    //on upload l'image
    if(move_uploaded_file($_FILES['img_url']['tmp_name'], "assets/medias/$user->id/.$extensionUpload_image")){
        $ad->imgUrl = "$user->id.$extensionUpload_image";
    }

    //on crée l'id unique
    $mail_crypt = \classified_ads\Crypt::encryptSimple($user->mail);
    
    // $ad->uniqueId = urlencode(\classified_ads\Crypt::encryptSimple("mail=$user->mail"));
    $ad->uniqueId = "TOTO";
    // var_dump(\classified_ads\Crypt::decryptSimple(urldecode($ad->uniqueId)));
    // var_dump($ad->uniqueId = urlencode(\classified_ads\Crypt::encryptSimple("mail=$user->mail"));


    //ajout l'annonce dans la bdd
    \classified_ads\Ad::add($ad);

    $id_crypt = \classified_ads\Crypt::encryptSimple(\classified_ads\Ad::getId($ad->uniqueId));
    
    \classified_ads\Ad::updateId($ad->uniqueId,hash('sha1',"$mail_crypt&$id_crypt"));


    

    //envoi mail de confirmation
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    // $headers .= "From: eze <dede@dede.fr>\r\nReply-to :dsd <dsds@fko.fr>\nX-Mailer:PHP";

    $sujet = "Validation de votre annonce";
    $message = "<a href = '".SERVER_URI."/confirm-$mail_crypt&$id_crypt'>validation</a>\n edition: <a href = '".SERVER_URI."/edit-$mail_crypt&$id_crypt'>validation</a>";
    
    var_dump(mail($user->mail, $sujet,$message,implode("\r\n", $headers)));


}

// echo json_encode(array('validation' => $validation,'erreurs' => $erreurs));