<?php

namespace ApplicantBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EvaluationJobRepository extends EntityRepository
{
    public function getAllOrdered()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT j
                FROM ApplicantBundle:EvaluationJob j
                ORDER BY j.label ASC'
            );

        return $query->getResult();
    }
}
