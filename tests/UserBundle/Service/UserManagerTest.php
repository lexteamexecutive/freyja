<?php

namespace Tests\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use UserBundle\Entity\User;

class UserManagerTest extends KernelTestCase
{
    public function testCreateUserWrongFormatUsername()
    {
        $user = new User();
        $user->setUsername('username');

        self::bootKernel();
        $userManager = self::$kernel->getContainer()->get('user.manager');

        $this->assertEquals(null, $userManager->createUser($user));
    }

    public function getUserManagerMock()
    {
        $mock = $this->getMockBuilder('UserBundle\Service\UserManager')
            ->setConstructorARgs(
                [
                    $this->getUserPasswordEncoderMock(),
                    $this->getEntityManagerMock(),
                ]
            )
            ->setMethods(['createUser', 'encodeUserPassword'])
            ->getMock();

        return $mock;
    }

    public function getEntityManagerMock()
    {
        $mock = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->setMethods(['persist', 'flush'])
            ->getMock();

        return $mock;
    }

    public function getUserPasswordEncoderMock()
    {
        $mock = $this->getMockBuilder('Symfony\Component\Security\Core\Encoder\UserPasswordEncoder')
            ->disableOriginalConstructor()
            ->setMethods(['encodePassword'])
            ->getMock();

        return $mock;
    }
}
