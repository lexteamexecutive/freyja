<?php

namespace ApplicantBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ApplicantRepository extends EntityRepository
{
    public function findAllByParam($search)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT a.id, CONCAT(a.firstName, ' ', a.lastName) AS text
                FROM ApplicantBundle:Applicant a
                WHERE a.firstName LIKE ?1
                OR a.lastName LIKE ?1"
            );
        $query->setParameter(1, '%' . $search . '%');

        return $query->getResult();
    }
}
