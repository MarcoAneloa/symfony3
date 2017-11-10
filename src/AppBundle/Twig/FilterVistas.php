<?php

namespace AppBundle\Twig;

class FilterVistas extends \Twig_Extension {

    public function getFilters(){
        return array(
            new \Twig_SimpleFilter("addText",array($this,'addText'))
        );
    }

    public function addText($string){
        return $string." Texto Concatenado";
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "filter_vista";
    }
}