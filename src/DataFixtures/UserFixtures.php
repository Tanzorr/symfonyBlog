<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    private $password_encoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->password_encoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$name, $password, $email, $role])
        {
            $user = new User();
            $user->setName($name);
            $user->setPassword($this->password_encoder->encodePassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($role);
            $manager->persist($user);
        }
        $manager->flush();
    }

    private function getUserData():array
    {
        return [
            ['John1', '1234', 'jh@ukr.net', '[ROLE_ADMIN]'],
            ['John2', '1234', 'jh2@ukr.net', '[ROLE_USER]'],
            ['John3', '1234', 'jh3@ukr.net', '[ROLE_USER]'],
            ['John4', '1234', 'jh4@ukr.net', '[ROLE_USER]'],
            ];
    }
}
