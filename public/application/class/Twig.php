<?php

namespace classified_ads;

/**
 * Undocumented class
 */
class Twig {

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    public $_template;

    /**
     * Undocumented function
     *
     * @param [type] $name
     */
    public function __construct($name){
        $loader = new \Twig\Loader\FilesystemLoader('application/template');
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        $this->_template = $twig->load($name);
    }
}