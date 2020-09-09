<?php

namespace classified_ads;

/**
 * Class Twig permettant de charger un template
 * 
 * @author Paturot A. <adrienpaturot@yahoo.fr>
 */
class Twig {

    public $_template;

    /**
     * Constructeur de classe
     *
     * @param [String] $name - nom du template
     */
    public function __construct($name){
        $loader = new \Twig\Loader\FilesystemLoader(dirname(dirname(__FILE__)).'/template');
        $twig = new \Twig\Environment($loader, [
            // 'cache' => (dirname(dirname(__FILE__)).'/cache'),
            'cache' => false,
        ]);

        $this->_template = $twig->load($name);
    }
}