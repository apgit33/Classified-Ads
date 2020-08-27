<?php
namespace classified_ads;
use PDO;

class Ad {

    public $desc;
    public $imgUrl;
    public $imgName;
    public $uniqueId;
    public $validate;
    public $dateCreate;
    public $dateValidate;
    public $catId;
    public $userId;

    /**
     * Undocumented function
     *
     * @return void
     */
    static function afficheAll(){
        
        $query = "SELECT `a_desc`,`a_image_url`,`a_image_name`,`a_unique_id`,`a_validate`,`a_date_create`,`a_date_validate`, `ca_category`.`c_name` FROM `ca_ad` LEFT JOIN `ca_category` on `ca_category`.`c_id` = `a_c_id`";
        
        return (\classified_ads\Bdd::executeSql($query,[],[]))->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    static function affiche($id){
  
        $query = "SELECT `a_desc`,`a_image_url`,`a_image_name`,`a_validate`,`a_date_create`,`a_date_validate`, `ca_category`.`c_name` FROM `ca_ad` LEFT JOIN `ca_category` on `ca_category`.`c_id` = `a_c_id` WHERE `a_id` = :id";
        $val = [":id"=>$id];
        $type = [":id"=>PDO::PARAM_INT];

        return (\classified_ads\Bdd::executeSql($query,$val,$type))->fetchALL(PDO::FETCH_ASSOC);
    }
}