<?php

namespace ApplicantBundle\Entity;

use ApplicantBundle\Entity\Applicant;
use ApplicantBundle\Entity\EvaluationJob;
use ApplicantBundle\Entity\EvaluationSpeciality;
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $oathTaking;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $firstExperience;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $firstExperienceBis;

    /**
     * Many Evaluations have One Job.
     *
     * @ORM\ManyToOne(targetEntity="EvaluationJob", inversedBy="evaluations")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id", nullable=true)
     */
    private $job;

    /**
     * Many Evaluations have One Speciality.
     *
     * @ORM\ManyToOne(targetEntity="EvaluationSpeciality", inversedBy="evaluations")
     * @ORM\JoinColumn(name="speciality_id", referencedColumnName="id", nullable=true)
     */
    private $speciality;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * One Evaluation has One Applicant.
     *
     * @ORM\OneToOne(targetEntity="Applicant", inversedBy="evaluation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="applicant_id", referencedColumnName="id")
     */
    private $applicant;

    public function getId()
    {
        return $this->id;
    }

    public function getOathTaking()
    {
        return $this->oathTaking;
    }

    public function setOathTaking($oathTaking)
    {
        $this->oathTaking = $oathTaking;
    }

    public function getFirstExperience()
    {
        return $this->firstExperience;
    }

    public function setFirstExperience($firstExperience)
    {
        $this->firstExperience = $firstExperience;
    }

    public function getFirstExperienceBis()
    {
        return $this->firstExperienceBis;
    }

    public function setFirstExperienceBis($firstExperienceBis)
    {
        $this->firstExperienceBis = $firstExperienceBis;
    }

    public function getJob()
    {
        return $this->job;
    }

    public function setJob($job)
    {
        $this->job = $job;
    }

    public function getSpeciality()
    {
        return $this->speciality;
    }

    public function setSpeciality($job)
    {
        $this->speciality = $speciality;
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
