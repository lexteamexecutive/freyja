<?php

namespace ApplicantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="evaluations_specialities")
 * @ORM\Entity(repositoryClass="ApplicantBundle\Repository\EvaluationSpecialityRepository")
 */
class EvaluationSpeciality
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $label;

    /**
     * Many Jobs has Many Evaluations.
     *
     * Many Groups have Many Users.
     * @ORM\ManyToMany(targetEntity="Evaluation", mappedBy="specialities")
     */
    private $evaluations;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
    }

    public function getId($id)
    {
        return $this->id;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getEvaluations()
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation)
    {
        $this->evaluations[] = $evaluation;
    }
}
