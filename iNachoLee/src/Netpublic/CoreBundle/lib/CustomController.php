<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomController
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\lib;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class CustomController extends Controller{    
    public function createFormCustomBuilder($nombre,$data = null, array $options = array()){        
        //return $this->container->get('form.factory')->createBuilder($nombre, $data, $options);        
        return $this->container->get('form.factory')->createNamedBuilder('form',$nombre, $data, $options);        
        
    }

}

?>
