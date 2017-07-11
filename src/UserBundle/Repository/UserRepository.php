<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findAllUF()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT u
                FROM UserBundle:User u
                WHERE u.roles NOT IN (?1)'
            );
        $query->setParameter(1, 'ROLE_SUPER_ADMIN');

        return $query->getResult();
    }
}
