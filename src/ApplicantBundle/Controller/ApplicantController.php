<?php

namespace ApplicantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/candidat")
 */
class ApplicantController extends Controller
{
    /**
     * @Route("/", name="applicant_home")
     */
    public function homeAction()
    {
        return $this->render('ApplicantBundle:Home:index.html.twig');
    }
}
