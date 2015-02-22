<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author yuri
 */
class Controller {
    function example($param) {
        
    //------------------------Profesor en sesion
    $user = $this->get('security.context')->getToken()->getUser();
    if(($user->getEsAlumno()==FALSE))
            $profesor=$user->getProfesor();            
    }
}

?>
