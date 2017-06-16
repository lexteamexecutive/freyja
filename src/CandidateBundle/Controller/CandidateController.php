<?php

namespace CandidateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CandidateController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('CandidateBundle:Default:index.html.twig');
    }
}
