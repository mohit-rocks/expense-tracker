<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AccountCategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user1 = $this->getReference(UserFixtures::USER_1_REFERENCE, User::class);
        $user2 = $this->getReference(UserFixtures::USER_2_REFERENCE, User::class);

        // Create accounts for user 1
        $account1 = new Account();
        $account1->setName('Bank Account 1');
        $account1->setCurrency('USD');
        $account1->setStartingBalance(1000);
        $account1->setCreatedBy($user1);
        $manager->persist($account1);

        $account2 = new Account();
        $account2->setName('Credit Card 1');
        $account2->setCurrency('USD');
        $account2->setStartingBalance(0);
        $account2->setCreatedBy($user1);
        $manager->persist($account2);

        // Create accounts for user 2
        $account3 = new Account();
        $account3->setName('Bank Account 2');
        $account3->setCurrency('EUR');
        $account3->setStartingBalance(500);
        $account3->setCreatedBy($user2);
        $manager->persist($account3);

        // Create categories for user 1
        $category1 = new Category();
        $category1->setName('Groceries');
        $category1->setCreatedBy($user1);
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName('Salary');
        $category2->setCreatedBy($user1);
        $manager->persist($category2);

        // Create categories for user 2
        $category3 = new Category();
        $category3->setName('Shopping');
        $category3->setCreatedBy($user2);
        $manager->persist($category3);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
