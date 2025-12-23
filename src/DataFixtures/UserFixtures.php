<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USER_1_REFERENCE = 'user-1';
    public const USER_2_REFERENCE = 'user-2';

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('admin@example.com');
        $user1->setFirstName('John');
        $user1->setLastName('Doe');
        $user1->setPassword($this->passwordHasher->hashPassword($user1, 'admin'));
        $user1->setIsVerified(true);
        $manager->persist($user1);
        $this->addReference(self::USER_1_REFERENCE, $user1);

        $user2 = new User();
        $user2->setEmail('user@example.com');
        $user2->setFirstName('Jane');
        $user2->setLastName('Doe');
        $user2->setPassword($this->passwordHasher->hashPassword($user2, 'user'));
        $user2->setIsVerified(true);
        $manager->persist($user2);
        $this->addReference(self::USER_2_REFERENCE, $user2);

        $manager->flush();
    }
}
