<?php

namespace ApplicantBundle\Entity;

use ApplicantBundle\Entity\Evaluation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Table(name="applicants")
 * @ORM\Entity(repositoryClass="ApplicantBundle\Repository\ApplicantRepository")
 */
class Applicant
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $cv;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $cvLastUpload;

    /**
     * One Applicant has One Evaluation.
     * @ORM\OneToOne(targetEntity="Evaluation", mappedBy="applicant", cascade={"persist"})
     */
    private $evaluation;

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv)
    {
        $this->cv = $cv;
    }

    public function setCvLastUpload()
    {
        $this->cvLastUpload = new \DateTime("now");
    }

    public function getCvLastUploaded()
    {
        return $this->cvLastUpload;
    }

    public function getEvaluation()
    {
        return $this->evaluation;
    }

    public function setEvaluation(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
    }

}
