<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Defi\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of CommonController
 *
 * @author sparrow
 */
class CommonController extends Controller {
    
    protected $viewParams;
    
    public function preExecute() {
        
        $em = $this->container->get("doctrine.orm.entity_manager");
        $bookRepository = $em->getRepository('DefiCommonBundle:Book');
        $partRepository = $em->getRepository('DefiCommonBundle:Part');
        $parts = $partRepository->findAll();
        $this->viewParams['parts'] = $parts;
        
        foreach ($parts as $part) {
            $this->viewParams['books'][$part->getId()] = $bookRepository->findByPart($part->getId());
        }
        
    }
    
}
