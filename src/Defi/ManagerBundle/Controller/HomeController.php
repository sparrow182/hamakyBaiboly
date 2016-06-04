<?php

namespace Defi\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('DefiManagerBundle:Home:index.html.twig');
    }
}
