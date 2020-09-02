<?php
namespace classified_ads;
use PDO;

/**
 * Class représentant une Annonce
 * 
 * @author Paturot A. <adrienpaturot@yahoo.fr>
 */
class Ad {

    public $desc;
    public $imgUrl;
    public $uniqueId;
    public $validate;
    public $dateCreate;
    public $dateValidate;
    public $catId;
    public $userId;

    /**
     * Constructeur de class
     */
    public function __construct()
    {
        $this->dateCreate = date('Y-m-d');
    }
    
    /**
     * Fonction statique qui récupère toutes les annonces validées pour les afficher
     *
     * @return tableau contenant les enregistrements
     */
    static function viewAll(){
        
        $query = "SELECT `a_desc`,`a_image_url`,`a_unique_id`,`a_date_create`,`a_date_validate`, `ca_category`.`c_name` FROM `ca_ad` LEFT JOIN `ca_category` on `ca_category`.`c_id` = `a_c_id` WHERE `a_validate` = true";
        
        return (\classified_ads\Bdd::executeSql($query,[],[]))->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * Fonction statique qui récupère un jeu de données sur une annonce particulière
     *
     * @param [Integer] $id
     * @return tableau contenant les enregistrements
     */
    static function view($id){
  
        $query = "SELECT `a_desc`,`a_image_url`,`a_validate`,`a_date_create`,`a_date_validate`, `ca_category`.`c_name` FROM `ca_ad` LEFT JOIN `ca_category` on `ca_category`.`c_id` = `a_c_id` WHERE `a_id` = :id";
        $val = [":id"=>$id];
        $type = [":id"=>PDO::PARAM_INT];

        return (\classified_ads\Bdd::executeSql($query,$val,$type))->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * Fonction statique d'ajout d'une annonce dans la base de données
     *
     * @param [Object Annonce] $ad
     * @return void
     */
    static function add($ad){
        $query = "INSERT INTO `ca_ad`(`a_desc`, `a_image_url`, `a_unique_id`, `a_date_create`, `a_c_id`, `a_u_id`) VALUES (:desc,:imgUrl, :uniqueId, :date,:catId,:uId)";

        $param = [':desc'=>$ad->desc,':imgUrl'=>$ad->imgUrl,':uniqueId'=>$ad->uniqueId,':date'=>$ad->dateCreate,':catId'=>$ad->catId,':uId'=>$ad->userId];
        
        $type=[':desc'=>PDO::PARAM_STR,':imgUrl'=>PDO::PARAM_STR,':uniqueId'=>PDO::PARAM_STR,':date'=>PDO::PARAM_STR,':catId'=>PDO::PARAM_STR,':uId'=>PDO::PARAM_STR];
        
        \classified_ads\Bdd::executeSql($query,$param,$type);

    }

    /**
     * Fonction statique de modification d'annonce
     *
     * @param [Object Annonce] $ad - annonce à modifier
     * @return void
     */
    static function modify($ad){
        $query = "UPDATE ca_ad SET a_desc=:desc, a_image_url=:imgUrl,a_c_id=:catId WHERE a_unique_id = :uniqueId";

        $param= [':desc'=>$ad->desc, ':imgUrl'=>$ad->imgUrl,':catId'=>$ad->catId,':uniqueId'=>$ad->uniqueId];

        $type= [':desc'=>PDO::PARAM_STR, ':imgUrl'=>PDO::PARAM_STR,':catId'=>PDO::PARAM_STR,':uniqueId'=>PDO::PARAM_STR];
        \classified_ads\Bdd::executeSql($query,$param,$type);
    }

    /**
     * Fonction statique de suppression d'annonce
     *
     * @param [String] $slug - annonce à supprimer
     * @return void
     */
    static function delete($slug){

        $query= "DELETE FROM ca_ad WHERE a_unique_id = :uniqueId";

        \classified_ads\Bdd::executeSql($query,[':uniqueId'=>hash('sha1',$slug)],[':uniqueId'=>PDO::PARAM_STR]);

    }

    /**
     * Fonction statique de validation d'une annonce
     * avec envoi de mail
     *
     * @param [String] $slug - annonce à valider
     * @return void
     */
    static function validate($slug) {

        $mail = \classified_ads\Crypt::decryptSimple(explode('&',$slug)[0]);
        $id = \classified_ads\Crypt::decryptSimple(explode('&',$slug)[1]);

        $mail_crypt = \classified_ads\Crypt::encryptSimple($mail);
        $id_crypt = \classified_ads\Crypt::encryptSimple($id);

        $new = hash('sha1',"$mail_crypt&$id_crypt");

        $query = "UPDATE ca_ad INNER JOIN ca_user ON ca_ad.a_u_id = ca_user.u_id SET a_validate = :validate, a_date_validate = :date, a_unique_id = :newUnique WHERE a_unique_id = :uniqueId AND u_mail = :mail AND a_id = :id ";

        $param = [':validate'=>true,':date'=>date('Y-m-d'),':newUnique'=>$new,':uniqueId'=>hash('sha1',$slug),':mail'=>$mail,':id'=>$id];

        $type = [':validate'=>PDO::PARAM_BOOL,':date'=>PDO::PARAM_STR,':newUnique'=>PDO::PARAM_STR,':uniqueId'=>PDO::PARAM_STR,':mail'=>PDO::PARAM_STR,':id'=>PDO::PARAM_INT];

        \classified_ads\Bdd::executeSql($query,$param,$type);

        \classified_ads\Ad::updateId(hash('sha1',$slug),$new);
        $message = "$mail_crypt\n$id_crypt ----------- <a href = '".SERVER_URI."/delete-$mail_crypt&$id_crypt>suppression </a>\n edition: <a href = '".SERVER_URI."/edit-$mail_crypt&$id_crypt'>edition</a>";

        mail($mail,"Validation de votre annonce",$message);

    }

    /**
     * Fonction statique récupérant l'id d'une annonce
     *
     * @param [Integer] $id - id unique de l'annonce
     * @return [integer] id
     */
    static function getId($id) {
        $query = "SELECT a_id FROM ca_ad WHERE a_unique_id = :id";
        return (\classified_ads\Bdd::executeSql($query,[':id'=>$id],[':id'=>PDO::PARAM_STR])->fetch(PDO::FETCH_ASSOC))['a_id'];
    }
    
    /**
     *  Fonction statique d'update de l'unique id d'une annonce
     *
     * @param [String] $id - id à modifier
     * @param [String] $new - nouvel id
     * @return void
     */
    static function updateId($id,$new){
        $query = "UPDATE ca_ad SET a_unique_id = :uniqueId WHERE a_unique_id = :id";
        $param = [':uniqueId'=>$new,':id'=>$id];
        $type = [':uniqueId'=>PDO::PARAM_STR,':id'=>PDO::PARAM_STR];
        \classified_ads\Bdd::executeSql($query,$param,$type);
    }
}