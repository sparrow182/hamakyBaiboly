<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Defi\CommonBundle\Manager;

/**
 * Description of StringManager
 *
 * @author sparrow
 */
class StringManager {
    
    public function removeSpecialChars($string) {
        $removed = strtolower($string);
        
        return preg_replace(array('/[\\/:\*\?"<>|\.,;]+/', '/\s/'), array('', '-'), $removed);
    }
    
    
}
