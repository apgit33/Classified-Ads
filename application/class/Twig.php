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

    static function index() {
        $twig = new \classified_ads\Twig('index.html.twig');

        $ads = \classified_ads\Ad::viewAll();

        echo $twig->_template->render([
            'list_ads' => $ads,
            'CAPTCHA_PUBLIC_KEY'=>CAPTCHA_PUBLIC_KEY,
            'SERVER_URI'=> SERVER_URI
        ]);
    }

    static function viewForm(){
        $twig = new \classified_ads\Twig('form.html.twig');
        $categories = \classified_ads\Category::getAll();
    
        echo $twig->_template->render([
            'titre' => "Ajouter une annonce",
            'list_category'=> $categories,
            'SERVER_URI'=> SERVER_URI
        ]);
    }

    static function editForm($slug) {
        $twig = new \classified_ads\Twig('form.html.twig');
        $categories = \classified_ads\Category::getAll();
    
        $ads = \classified_ads\Ad::getAd($slug);
        echo $twig->_template->render([
            'list_ads'=> $ads,
            'list_category'=> $categories,
            'SERVER_URI'=> SERVER_URI
        ]);
    }
}