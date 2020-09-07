<?php
namespace classified_ads;
use PDO,PDOException;

/**
 * Class gérant la connexion à la base de données
 * Permet aussi d'éxécuter une requete SQL
 * 
 * @author Paturot A. <adrienpaturot@yahoo.fr>
 */
class Bdd {

    const NAME ='classified_ads';
    const HOST = 'localhost';
    const USER = 'root';
    const PWD = '';

    /**
     * Fonction de connexion à la base de données
     *
     * @return Object instance de PDO
     * ou
     * @return String message d'erreur
     */
    static function connect(){
        try{
            $bdd = new PDO("mysql:hote=".SELF::HOST.";dbname=".SELF::NAME,SELF::USER,SELF::PWD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));	
        } catch(PDOException $e) {
			$msg = 'ERREUR PDO dans ' . $e->getFile() . ' Ligne.' . $e->getLine() . ' : <br>' . $e->getMessage();
			die($msg);
		}
		return $bdd;
    }
    
    /**
     * Fonction exécution requête préparée
     *
     * @param [string] $query
     * @param [array] $array - valeurs à bind
     * @param [array] $type - type des valeurs à bind
     * 
     * @return $sth - handler de la requete
     */
    static function executeSql($query,$array,$type) {
        $co = SELF::connect();		
        $sth = $co->prepare($query);
        foreach($array as $key => &$val){
            $sth->bindParam($key,$val,$type[$key]);
        }
        $sth->execute();

        return $sth;
    }

}