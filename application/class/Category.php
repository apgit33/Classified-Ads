<?php
namespace classified_ads;

/**
 * Class représentant les categories
 * 
 * @author Paturot A. <adrienpaturot@yahoo.fr>
 */
class Category {
    
    /**
     * Fonction de récupération des catégories
     *
     * @return tableau contenant les enregistrements
     */
    static function getAll() {
        $query = "SELECT c_id, c_name FROM ca_category";
        $response = \classified_ads\Bdd::executeSql($query);

        return $response->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère le nom de la catégorie
     *
     * @param [int] $id
     * @return string
     */
    static function getName($id){
        $query = "SELECT c_name FROM ca_category WHERE c_id = :id";
        $response = \classified_ads\Bdd::executeSql($query,[':id'=>$id],[':id'=>\PDO::PARAM_INT]);
        $response->fetch(\PDO::FETCH_ASSOC);
        return $response['c_name'];
    }
}