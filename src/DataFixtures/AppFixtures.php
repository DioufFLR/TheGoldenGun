<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Supplier;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        // Création de 10 fournisseurs

        for ($i = 0; $i < 10; ++$i) {
            $supplier = new Supplier();
            $supplier->setSupplierName($faker->company)
                ->setSupplierPhone($faker->phoneNumber)
                ->setSupplierCity($faker->city)
                ->setSupplierAdress($faker->address)
                ->setSupplierPC($faker->postcode)
                ->setSupplierCountry($faker->country);
            $manager->persist($supplier);
        }

        // Création de 10 users

        for ($i = 0; $i < 10; ++$i) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setRoles($faker->randomElement([['ROLE_USER'], ['ROLE_OWNER'], ['ROLE_SUPER_USER']]))
                ->setPassword($faker->password)
                ->setUserName($faker->userName)
                ->setUserFirstName($faker->firstName)
                ->setUserAdress($faker->address)
                ->setUserCity($faker->city)
                ->setUserPC($faker->postcode)
                ->setUserPhone($faker->phoneNumber)
                ->setUserPicture($faker->image(width: 100, height: 100))
                ->setUserType($faker->randomElement(['0', '1', '2']));
            $manager->persist($user);
        }

        // Création de 8 catégories

        $categorySub = new Category();
        $categorySub->setCategoryName('Pistolet')
            ->setCategorySub(2)
            ->setCategoryPicture('2151s2df23as1dfasdf');
        $manager->persist($categorySub);

//        $category = new Category();
//        $category->setCategoryName('Armes de poing')
//            ->setCategoryPicture('asdlkfjasldfladsjfladf')
//            ->setCategorySub('');
//        $manager->persist($category);

        $manager->flush();
    }
}
