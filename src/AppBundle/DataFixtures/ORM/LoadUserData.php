<?php

namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface */
    private $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    public function load(ObjectManager $manager)
    {
        $admin = $this->createActiveUser('admin', 'admin@admin.com','admin', ['ROLE_ADMIN']);
        $moderator = $this->createActiveUser('moderator','moderator@moderator.com', 'moderator', ['ROLE_MODERATOR']);
        $user = $this->createActiveUser('user','user@user.com', 'user');

        $manager->persist($admin);
        $manager->persist($moderator);
        $manager->persist($user);
        $manager->flush();
    }
    private function createActiveUser($username, $email, $plainPassword, $roles = ['ROLE_USER'])
    {
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setIsActive(true);
        $encodedPassword = $this->encodePassword($user, $plainPassword);
        $user->setPassword($encodedPassword);
        return $user;
    }

    private function encodePassword($user, $plainPassword)
    {
        $encoder = $this->container->get('security.password_encoder');
        $encodedPassword = $encoder->encodePassword($user, $plainPassword);
        return $encodedPassword;
    }
}