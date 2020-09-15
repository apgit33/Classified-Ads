<?php

namespace classified_ads;
use PDO;

/**
 * Class User représentant un utilisateur
 * @author Paturot A. <adrienpaturot@yahoo.fr>
 */
class User {

    public $id;
    public $mail;
    public $firstName;
    public $lastName;
    public $phone;
    
    /**
     * Fonction permettant de vérifier si l'utilisateur est déjà dans la base
     * de donnée, si non on l'insert. Le but est aussi de récupérer l'id du User 
     * et de l'attribuer à celui-ci
     *
     * @return void
     */
    public function getUserId(){
        $query = "SELECT u_id FROM ca_user WHERE u_mail = :mail AND u_first_name = :fname AND u_last_name = :lname AND u_phone = :phone";
        $param = [':mail'=>$this->mail,':fname'=>$this->firstName, ':lname'=>$this->lastName,':phone'=>$this->phone];
        $type = [':mail'=>PDO::PARAM_STR,':fname'=>PDO::PARAM_STR, ':lname'=>PDO::PARAM_STR,':phone'=>PDO::PARAM_STR];
        if ($data = \classified_ads\Bdd::executeSql($query,$param,$type)->fetch(PDO::FETCH_ASSOC)) {
            $this->id = $data['u_id'];
        } else {
            $query = "INSERT INTO `ca_user`(`u_mail`, `u_first_name`, `u_last_name`, `u_phone`) VALUES (:mail,:fname,:lname,:phone)";
            $co = Bdd::connect();		
            $sth = $co->prepare($query);
            foreach($param as $key => &$val){
                $sth->bindParam($key,$val,$type[$key]);
            }
            $sth->execute();
            $this->id = $co->lastInsertId();
        }
    }

    public function setUser($mail) {
        $query = "SELECT u_first_name,u_last_name,u_phone FROM ca_user WHERE u_mail = :mail";
        $reponse = \classified_ads\Bdd::executeSql($query,[':mail'=>$mail],[':mail'=>PDO::PARAM_STR]);
        if($data = $reponse->fetch(PDO::FETCH_ASSOC)){
            $this->mail = $mail;
            $this->firstName = $data['u_first_name'];
            $this->lastName = $data['u_last_name'];
            $this->phone = $data['u_phone'];
        }
    }
    
    static function checkUser($user){
        $query = "SELECT u_first_name,u_last_name,u_phone FROM ca_user WHERE u_mail = :mail";
        $reponse = \classified_ads\Bdd::executeSql($query,[':mail'=>$user->mail],[':mail'=>PDO::PARAM_STR]);
        if($data = $reponse->fetch(PDO::FETCH_ASSOC)){
            return (strcasecmp($user->firstName,$data['u_first_name']) == 0 && strcasecmp($user->lastName,$data['u_last_name']) == 0 && strcasecmp($user->phone,$data['u_phone']) == 0);
        }else{
            return true;
        }
    }
}