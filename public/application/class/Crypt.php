<?php

namespace classified_ads;

/**
 * Class Crypt permettant de crypter et décrypter une chaine
 * de caractères suivant la norme en paramètre de classe
 * 
 * @author Paturot A. <adrienpaturot@yahoo.fr>
 */
class Crypt {
    public static $encryption_key = "ADs-2525";
    public static $cipher = "aes-128-cbc";

    /**
     * Fonction d'encryptage
     *
     * @param [String] $string - texte
     * @return [String] $iv.$cipher_text - texte crypté
     */
    public static function encryptSimple($string){
        $options = 0;
        $ivlen = openssl_cipher_iv_length(self::$cipher);

        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $iv = "";

        for($i=0;$i<$ivlen;$i++) {
            $iv .= $characters[random_int(0,61)];
        }
        $cipher_text = openssl_encrypt($string,self::$cipher,self::$encryption_key,$options,$iv);

        return $iv.$cipher_text;
    }

    /**
     * Fonction d'encryptage
     *
     * @param [String] $cipher_string - texte crypté
     * @return [String] texte décrypté 
     */
    public static function decryptSimple($cipher_string){
        $options = 0;
        $ivlen = openssl_cipher_iv_length(self::$cipher);
        $iv = substr($cipher_string,0,$ivlen);
        $cipher_raw = substr($cipher_string,$ivlen);

        return openssl_decrypt($cipher_raw,self::$cipher,self::$encryption_key,$options,$iv);
    }
}