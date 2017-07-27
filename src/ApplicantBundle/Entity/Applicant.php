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
    private $civilStatus;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $email1;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $email2;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $portable1;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $portable2;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\File(
     *     maxSize = "10M",
     * )
     */
    private $cv;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $cvCom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $cvLastUpload;

    /**
     * One Applicant has One Evaluation.
     * @ORM\OneToOne(targetEntity="Evaluation", mappedBy="applicant", cascade={"persist", "remove"})
     */
    private $evaluation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastUpdate;

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

    public function getCivilStatus()
    {
        return $this->civilStatus;
    }

    public function setCivilStatus($civilStatus)
    {
        $this->civilStatus = $civilStatus;
    }

    public function getSexe()
    {
        return $this->sexe;
    }

    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getEmail1()
    {
        return $this->email1;
    }

    public function setEmail1($email1)
    {
        $this->email1 = $email1;
    }

    public function getEmail2()
    {
        return $this->email2;
    }

    public function setEmail2($email2)
    {
        $this->email2 = $email2;
    }

    public function getPortable1()
    {
        return $this->portable1;
    }

    public function setPortable1($portable1)
    {
        $this->portable1 = $portable1;
    }

    public function getPortable2()
    {
        return $this->portable2;
    }

    public function setPortable2($portable2)
    {
        $this->portable2 = $portable2;
    }

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv)
    {
        $this->cv = $cv;
    }

    public function getCvCom()
    {
        return $this->cvCom;
    }

    public function setCvCom($cvCom)
    {
        $this->cvCom = $cvCom;
    }

    public function setCvLastUpload()
    {
        $this->cvLastUpload = new \DateTime("now");
    }

    public function getCvLastUpload()
    {
        return $this->cvLastUpload;
    }

    public function setLastUpdate()
    {
        $this->lastUpdate = new \DateTime("now");
    }

    public function getLastUpdate()
    {
        return $this->lastUpdate;
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
