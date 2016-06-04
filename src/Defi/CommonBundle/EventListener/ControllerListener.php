<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Defi\CommonBundle\EventListener;

use Symfony\Component\HttpKernel\HttpKernelInterface; 
use Symfony\Component\HttpKernel\Event\FilterControllerEvent; 

/**
 * Description of ControllerListener
 *
 * @author sparrow
 */
class ControllerListener {
    
    public function onCoreController(FilterControllerEvent $event) 	
    {
        // Récupération de l'event 	
        if(HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) 
        {
            // Récupération du controller    
            $_controller = $event->getController();
            
            if (isset($_controller[0])) 
            {
                $controller = $_controller[0];
                
                if(method_exists($controller,'preExecute'))
                {
                    $controller->preExecute();
                }
            }
        }
 
    }
}
