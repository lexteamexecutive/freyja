<?php

namespace Tests\UserBundle\Command;

use UserBundle\Command\CreateSuperUserCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CreateUserCommandTest extends KernelTestCase
{
    public function testExecuteMailFormat()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new CreateSuperUserCommand());

        $command = $application->find('user:create-super');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),

            // pass arguments to the helper
            'username' => 'username',
            'password' => 'password',
        ));

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('Username must have a mail format', $output);
    }

    public function testExecute()
    {
        self::bootKernel();

        $userManagerMock = $this->getUserManagerMock();
        $userManagerMock->expects($this->once())
            ->method('createUser')
            ->willReturn(true);
        self::$kernel->getContainer()->set('user.manager', $userManagerMock);

        $application = new Application(self::$kernel);

        $command = $application->find('user:create-super');
        $command->setContainer(self::$kernel->getContainer());
        $commandTester = new CommandTester($command);

        $application->add(new CreateSuperUserCommand());

        $commandTester->execute(array(
            'command'  => $command->getName(),

            // pass arguments to the helper
            'username' => 'username@gmail.com',
            'password' => 'password',
        ));

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('User "username@gmail.com" successfully generated!', $output);
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
