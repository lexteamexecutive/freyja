<?php

namespace UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use UserBundle\Entity\User;

class CreateSuperUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('user:create-super')
        ->addArgument(
            'username',
            InputArgument::REQUIRED,
            'The username of the user (Email required).'
        )
        ->addArgument(
            'password',
            InputArgument::REQUIRED,
            'The password of the user.'
        )

        // the short description shown while running "php bin/console list"
        ->setDescription('Creates a super user.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to create a super user.')
  ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'User Creator',
            '============',
        ]);

        $userManager = $this->getContainer()->get('user.manager');
        $user = new User();
        $user->setUsername($input->getArgument('username'));
        $user->setPlainPassword($input->getArgument('password'));
        $user->setRoles('ROLE_SUPER_ADMIN');

        if ($userManager->createUser($user)) {
            $output->writeln('<info>User "' . $input->getArgument('username') . '" successfully generated!</info>');
        } else {
            $output->writeln('<error>Username must have a mail format.</error>');
        }

    }
}
