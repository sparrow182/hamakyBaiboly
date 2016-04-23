<?php

namespace Defi\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DefiCommonBundle:Default:index.html.twig');
    }
}
