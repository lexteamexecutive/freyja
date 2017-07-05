<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/")
 */
class FrontController extends Controller
{
    /**
     * @Route("/", name="front_dashboard")
     */
    public function dashboardAction()
    {
        return $this->render('FrontBundle:Dashboard:index.html.twig');
    }
}
