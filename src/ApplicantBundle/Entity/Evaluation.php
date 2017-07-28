<?php

namespace ApplicantBundle\Entity;

use ApplicantBundle\Entity\Applicant;
use ApplicantBundle\Entity\EvaluationJob;
use ApplicantBundle\Entity\EvaluationSpeciality;
use Doctrine\Common\Collections\ArrayCollection;
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
     * Many Evaluations have Many Specialities.
     *
     * @ORM\ManyToMany(targetEntity="EvaluationSpeciality", inversedBy="evaluations", cascade={"persist"})
     * @ORM\JoinTable(name="evaluations_specialities_join")
     */
    private $specialities;

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

    public function __construct()
    {
        $this->specialities = new ArrayCollection();
    }

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

    public function getSpecialities()
    {
        return $this->specialities;
    }

    public function setSpecialities($specialities)
    {
        $this->specialities = $specialities;
    }

    public function addSpeciality(EvaluationSpeciality $speciality)
    {
        $speciality->add($this);
        $this->specialities[] = $speciality;
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
