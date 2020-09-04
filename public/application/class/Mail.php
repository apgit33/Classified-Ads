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
    static function mailTo($mail,$sujet,$message){

        // Create the Transport
        $transport = (new \Swift_SmtpTransport('smtp.mail.yahoo.com', 465,'ssl'))
        ->setUsername('adrienpaturot')
        ->setPassword('Avbelbob33')
        ;      

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message($sujet))
        ->setContentType("text/html")
        ->setFrom(["adrienpaturot@yahoo.fr" => 'John Doe']) //à voir plus tard
        ->setTo([$mail => 'Adrien Paturot'])
        ->setBody($message)
        ;

        // Send the message
        $mailer->send($message);
    }
}