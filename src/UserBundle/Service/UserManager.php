<?php

namespace UserBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use UserBundle\Entity\User;

class UserManager
{
    /**
     * Symfony Security | Password Encoder
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;

    /**
     * Doctrine | EntityManager
     * @var EntityManager
     */
    private $em;

    public function __construct(
        UserPasswordEncoder $passwordEncoder,
        EntityManager $em
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->em = $em;
    }

    public function createUser(User $user)
    {
        if (filter_var($user->getUsername(), FILTER_VALIDATE_EMAIL) === false) {
            return;
        }

        $this->encodeUserPassword($user);

        $this->em->persist($user);
        $this->em->flush();

        return true;
    }

    public function encodeUserPassword(User $user)
    {
        if (empty($user) || empty($user->getPlainPassword())) {
            return;
        }

        $password = $this->passwordEncoder
            ->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        return true;
    }
}
