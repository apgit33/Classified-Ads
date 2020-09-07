<?php
namespace classified_ads;
use PDO;

/**
 * Class représentant une Annonce
 * 
 * @author Paturot A. <adrienpaturot@yahoo.fr>
 */
class Ad {

    public $title;
    public $description;
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
        $limit = 0;
        $nombre = 10; //à voir plus tard
        $query = "SELECT `a_desc`,`a_image_url`,`a_unique_id`,`a_date_create`,`a_date_validate`, `ca_category`.`c_name` FROM `ca_ad` LEFT JOIN `ca_category` on `ca_category`.`c_id` = `a_c_id` WHERE `a_validate` = true LIMIT $limit,$nombre";
        
        $response = \classified_ads\Bdd::executeSql($query,[],[]);
        return $response->fetchALL(PDO::FETCH_ASSOC);
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

        $response = \classified_ads\Bdd::executeSql($query,$val,$type);
        return $response->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * Fonction statique d'ajout d'une annonce dans la base de données
     *
     * @param [Object Annonce] $ad
     * @return void
     */
    static function add($ad){
        $query = "INSERT INTO `ca_ad`(`a_title`,`a_desc`, `a_image_url`, `a_unique_id`, `a_date_create`, `a_c_id`, `a_u_id`) VALUES (:title,:desc,:url, :uniqueId, :date,:catId,:uId)";

        $param = [
            ':title'=>$ad->title,
            ':desc'=>$ad->description,
            ':url'=>$ad->imgUrl,
            ':uniqueId'=>$ad->uniqueId,
            ':date'=>$ad->dateCreate,
            ':catId'=>$ad->catId,
            ':uId'=>$ad->userId
        ];
        
        $type=[':title'=>PDO::PARAM_STR,':desc'=>PDO::PARAM_STR,':url'=>PDO::PARAM_STR,':uniqueId'=>PDO::PARAM_STR,':date'=>PDO::PARAM_STR,':catId'=>PDO::PARAM_STR,':uId'=>PDO::PARAM_STR];
        
        \classified_ads\Bdd::executeSql($query,$param,$type);
    }

    /**
     * Fonction statique de modification d'annonce
     *
     * @param [Object Annonce] $ad - annonce à modifier
     * @return void
     */
    static function modify($ad){
        $query = "UPDATE ca_ad SET a_desc=:desc, a_image_url=:url,a_c_id=:catId WHERE a_unique_id = :uniqueId";

        $param= [':desc'=>$ad->description, ':url'=>$ad->imgUrl,':catId'=>$ad->catId,':uniqueId'=>$ad->uniqueId];

        $type= [':desc'=>PDO::PARAM_STR, ':url'=>PDO::PARAM_STR,':catId'=>PDO::PARAM_STR,':uniqueId'=>PDO::PARAM_STR];
        \classified_ads\Bdd::executeSql($query,$param,$type);
    }

    /**
     * Fonction statique de suppression d'annonce
     *
     * @param [String] $slug - annonce à supprimer
     * @return void
     */
    static function delete($slug){

        $query= "SELECT a_id FROM ca_ad WHERE a_unique_id = :uniqueId";

        $response = \classified_ads\Bdd::executeSql($query,[':uniqueId'=>hash('sha1',$slug)],[':uniqueId'=>PDO::PARAM_STR]);
        if($response->fetch(PDO::FETCH_ASSOC)){
            $query= "DELETE FROM ca_ad WHERE a_unique_id = :uniqueId";

            \classified_ads\Bdd::executeSql($query,[':uniqueId'=>hash('sha1',$slug)],[':uniqueId'=>PDO::PARAM_STR]);
            return true;
        }else{
            return false;
        }
    }

    /**
     * Fonction statique de validation d'une annonce
     * avec envoi de mail
     *
     * @param [String] $slug - annonce à valider
     * @return [Boolean]
     */
    static function validate($slug) {

        $mail = \classified_ads\Crypt::decryptSimple(explode('&',$slug)[0]);
        $id = \classified_ads\Crypt::decryptSimple(explode('&',$slug)[1]);
        $user = new User();
        $user->setUser($mail);
        $title = \classified_ads\Ad::getAdTitle($slug);

        $query = "SELECT a_id FROM ca_ad INNER JOIN ca_user ON ca_ad.a_u_id = ca_user.u_id WHERE a_unique_id = :id AND u_mail = :mail ";
        $response = \classified_ads\Bdd::executeSql($query,[':id'=>hash('sha1',$slug),':mail'=>$mail],[':id'=>PDO::PARAM_INT,':mail'=>PDO::PARAM_STR]);

        if($response->fetch(PDO::FETCH_ASSOC)){
            
            $mail_crypt = \classified_ads\Crypt::encryptSimple($mail);
            $id_crypt = \classified_ads\Crypt::encryptSimple($id);
    
            $new = hash('sha1',"$mail_crypt&$id_crypt");
    
            $query = "UPDATE ca_ad INNER JOIN ca_user ON ca_ad.a_u_id = ca_user.u_id SET a_validate = :validate, a_date_validate = :date, a_unique_id = :newUnique WHERE a_unique_id = :uniqueId AND u_mail = :mail AND a_id = :id ";
    
            $param = [':validate'=>true,':date'=>date('Y-m-d'),':newUnique'=>$new,':uniqueId'=>hash('sha1',$slug),':mail'=>$mail,':id'=>$id];
    
            $type = [':validate'=>PDO::PARAM_BOOL,':date'=>PDO::PARAM_STR,':newUnique'=>PDO::PARAM_STR,':uniqueId'=>PDO::PARAM_STR,':mail'=>PDO::PARAM_STR,':id'=>PDO::PARAM_INT];
            
            \classified_ads\Bdd::executeSql($query,$param,$type)->fetch();

            $message = "To delete your ad, click on this link <a href = '".SERVER_URI."/delete-$mail_crypt&$id_crypt'>DELETE </a>";
    
            \classified_ads\Mail::mailTo($user,"Congratulation ! Your ad $title is now validate",$message);

            return true;
        }else{
            return false;
        }
    }

    /**
     * Fonction statique récupérant l'id d'une annonce
     *
     * @param [Integer] $id - id unique de l'annonce
     * @return [integer] id
     */
    static function getId($id) {
        $query = "SELECT a_id FROM ca_ad WHERE a_unique_id = :id";
        $response = \classified_ads\Bdd::executeSql($query,[':id'=>$id],[':id'=>PDO::PARAM_STR]);
        
        return $response->fetch(PDO::FETCH_ASSOC)['a_id'];
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


    static function getAd($slug){
        $query = "SELECT * FROM ca_ad INNER JOIN ca_user ON a_u_id = u_id WHERE a_unique_id = :id";
        return \classified_ads\Bdd::executeSql($query,[':id'=>hash('sha1',$slug)],[':id'=>PDO::PARAM_STR])->fetchALL(PDO::FETCH_ASSOC);
    }

    static function getAdTitle($slug){
        $query = "SELECT a_title FROM ca_ad WHERE a_unique_id = :id";
        $reponse = \classified_ads\Bdd::executeSql($query,[':id'=>hash('sha1',$slug)],[':id'=>PDO::PARAM_STR]);
        $data = $reponse->fetch(PDO::FETCH_ASSOC);
        
        return $data['a_title'];
    }
}