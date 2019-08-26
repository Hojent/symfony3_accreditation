<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;


class AddAdminUserCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:add-admin-user';

    protected function configure()
    {
        $this
            ->setDescription('Add admin user: username  password  email.')
            ->addArgument('username', InputArgument::REQUIRED)
            ->addArgument('password', InputArgument::REQUIRED)
            ->addArgument('email', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');

        $user = new User();
        $passwordEncoder = new BCryptPasswordEncoder(12);

        $password = $passwordEncoder->encodePassword($input->getArgument('username'), $input->getArgument('password'));

            $user->setUsername($input->getArgument('username'));
            $user->setPassword($password);
            $user->setRoles(['ROLE_ADMIN']);
            $user->setEmail($input->getArgument('email'));

        $entityManager->persist($user);
        $entityManager->flush();

        $output->writeln(
            sprintf('Admin account "%s" has been created', $user->getUsername())
        );
    }
}

