<?php

/*
 * Copyright 2011 Piotr Śliwa <peter.pl7@gmail.com>
 *
 * License information is in LICENSE file
 */

namespace Netpublic\CoreBundle\Twig\Extensions\Extension;




/**
 * Twig extension
 * 
 * @author Piotr Śliwa <peter.pl7@gmail.com>
 */
class InachoLeeExtension extends \Twig_Extension
{
    private $number_float;
    
    public function __construct($number_float)
    {
        $this->number_float = $number_float;
    }
    
    public function getFunctions()
    {
        return array(
            'redondear' => new \Twig_Function_Method($this, 'redondear'),
        );
    }
    
    public function getName()
    {
        return 'redondear';
    }
    
    public function redondear($number_float,$cifras)
    {
        
        return number_format ($number_float,$cifras);
    }
    
}

