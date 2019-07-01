<?php

namespace App\DataFixtures;

use App\Entity\Buyer;
use App\Entity\BankAccount;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $bankAccount = new BankAccount();
        $bankAccount->setNumber('1111 2222 3333 4444 5555');
        $manager->persist($bankAccount);

        $buyer1 = new Buyer();
        $buyer1->setName('Test');
        $buyer1->setNip('123456789');
        $manager->persist($buyer1);

        $buyer2 = new Buyer();
        $buyer2->setName('Test1');
        $buyer2->setNip('987654321');
        $manager->persist($buyer2);

        $manager->flush();
    }
}
