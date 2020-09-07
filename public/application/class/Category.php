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
        $query = "SELECT c_name FROM ca_category";
        $response = \classified_ads\Bdd::executeSql($query,null,null);

        return $response->fetchAll(\PDO::FETCH_ASSOC);
    }
}