<?php

namespace ApplicantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Table(name="applicants")
 * @ORM\Entity(repositoryClass="ApplicantBundle\Repository\ApplicantRepository")
 * @UniqueEntity(fields="username", message="Cet Email est déjà utilisé")
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
     * @ORM\Column(type="string", length=100)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastName;
}
