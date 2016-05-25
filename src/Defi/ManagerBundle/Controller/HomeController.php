<?php

namespace Defi\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DefiManagerBundle:Default:index.html.twig');
    }
}
