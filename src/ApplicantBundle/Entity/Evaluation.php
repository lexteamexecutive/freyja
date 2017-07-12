<?php

namespace ApplicantBundle\Entity;

use ApplicantBundle\Entity\Applicant;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Table(name="evaluations")
 * @ORM\Entity(repositoryClass="ApplicantBundle\Repository\EvaluationRepository")
 */
class Evaluation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * One Evaluation has One Applicant.
     * @ORM\OneToOne(targetEntity="Applicant", inversedBy="evaluation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="applicant_id", referencedColumnName="id")
     */
    private $applicant;

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getApplicant()
    {
        return $this->applicant;
    }

    public function setApplicant(Applicant $applicant)
    {
        $this->applicant = $applicant;
    }
}
