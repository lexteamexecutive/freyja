<?php

namespace CandidateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/candidat")
 */
class CandidateController extends Controller
{
    /**
     * @Route("/", name="candidate_home")
     */
    public function indexAction()
    {
        return $this->render('CandidateBundle:Default:index.html.twig');
    }
}
