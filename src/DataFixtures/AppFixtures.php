<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Advice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        // Création d'un utilisateur admin
        $admin = new User();
        $admin->setLogin('admin');
        $admin->setCity('Paris');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'adminpass'));
        $manager->persist($admin);

        // Création d'un utilisateur classique
        $user = new User();
        $user->setLogin('jardiner');
        $user->setCity('Lyon');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'userpass'));
        $manager->persist($user);

        // Création de quelques conseils
        $advice1 = new Advice();
        $advice1->setContent('Arroser les plantes tôt le matin.');
        $advice1->setMonths([4, 5, 6]);
        $manager->persist($advice1);

        $advice2 = new Advice();
        $advice2->setContent('Tailler les arbres fruitiers en février.');
        $advice2->setMonths([2]);
        $manager->persist($advice2);

        $manager->flush();
    }
}
