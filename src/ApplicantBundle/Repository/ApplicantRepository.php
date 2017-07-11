<?php

namespace ApplicantBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ApplicantRepository extends EntityRepository
{
    public function findAllByParam($search)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT a.id, a.firstName AS text
                FROM ApplicantBundle:Applicant a
                WHERE a.firstName NOT IN (?1)
                OR a.lastName NOT IN (?1)'
            );
        $query->setParameter(1, $search);

        return $query->getResult();
    }
}
