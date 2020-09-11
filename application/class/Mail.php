<?php

namespace classified_ads;
/**
 * Class Mail gérant l'envoi d'e-mail
 * @author Paturot A. <adrienpaturot@yahoo.fr>
 */
class Mail {

    /**
     * function d'envoi de mail avec le header pré-rempli
     *
     * @param [String] $mail    - Destinataire
     * @param [String] $sujet   - Sujet du mail
     * @param [String] $message - Message du mail
     * @return void
     */
    static function mailTo($user,$sujet,$message){

        // Create the Transport
        $transport = (new \Swift_SmtpTransport(SMTP,PORT,SECURITY))
        ->setUsername(MAIL_USER_NAME)
        ->setPassword(MAIL_PASSWORD)
        ;

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        $body = "Hello $user->firstName $user->lastName,<br><br>";
        $body .= $message;
        // Create a message
        $message = (new \Swift_Message($sujet))
        ->setContentType("text/html")
        ->setFrom([MAIL => FIRST_NAME.LAST_NAME])
        ->setTo([$user->mail => "$user->firstName $user->lastName"])
        ->setBody($body)
        ;

        // Send the message
        $mailer->send($message);
    }
}