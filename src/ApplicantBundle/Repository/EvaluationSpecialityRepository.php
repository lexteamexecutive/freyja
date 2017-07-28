<?php

namespace ApplicantBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EvaluationSpecialityRepository extends EntityRepository
{
    public function getAllOrdered()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT s
                FROM ApplicantBundle:EvaluationSpeciality s
                ORDER BY s.label ASC'
            );

        return $query->getResult();
    }
}
