<?php

namespace FrontBundle\Service;

use ApplicantBundle\Entity\Applicant;
use Symfony\Component\HttpFoundation\Session\Session;

class ApplicantBag
{
    /**
     * Symfony Session
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function addApplicantInBag(Applicant $applicant)
    {
        $applicantsBag = $this->session->get('applicant');
        
        if($applicantsBag !== null) {
            foreach ($applicantsBag as $key => $applicantInBag) {
                if ($applicant->getId() === $applicantInBag->getid()) {
                    unset($applicantsBag[$key]);
                }
            }
        }

        $applicantsBag[] = $applicant;
        $this->session->set('applicant', $applicantsBag);
    }
}
