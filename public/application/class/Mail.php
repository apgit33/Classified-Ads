<?php

namespace classified_ads;

/**
 * Class Mail gérant l'envoi d'e-mail
 */
class Mail {

    private static $headers;

    /**
     * function d'envoi de mail avec le header pré-rempli
     *
     * @param [String] $mail    - Destinataire
     * @param [String] $sujet   - Sujet du mail
     * @param [String] $message - Message du mail
     * @return void
     */
    static function mailTo($mail,$sujet,$message){
        self::$headers[] = 'MIME-Version: 1.0';
        self::$headers[] = 'Content-type: text/html; charset=iso-8859-1';

        mail($mail,$sujet,$message,implode("\r\n",self::$headers));
    }

}