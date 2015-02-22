<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Calculator
 *
 * @author yuri
 */
class Calculator {
     /**
     * @assert (0, 0) == 0
     * @assert (0, 1) == 1
     * @assert (1, 0) == 1
     * @assert (1, 1) == 2
     * @assert (1, 2) == 4
     */
    public function add($a, $b)
    {
        return $a+$b;
    }
}

?>
