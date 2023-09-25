<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Supplier;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use phpDocumentor\Reflection\Types\Null_;

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

        $mainCategory = new Category();
        $mainCategory->setCategoryName('Armes de poing')
            ->setCategoryPicture($faker->image(width: 200, height: 200));
        $manager->persist($mainCategory);

        $mainCategory2 = new Category();
        $mainCategory2->setCategoryName("Armes d'épaule")
            ->setCategoryPicture($faker->image(width: 200, height: 200));
        $manager->persist($mainCategory2);

        $category3 = new Category();
        $category3->setCategoryName('Revolver')
            ->setCategorySub($mainCategory)
            ->setCategoryPicture($faker->image(width: 200, height: 200));
        $manager->persist($category3);

        $category4 = new Category();
        $category4->setCategoryName('Pistolet')
            ->setCategorySub($mainCategory)
            ->setCategoryPicture($faker->image(width: 200, height: 200));
        $manager->persist($category4);

        $category5 = new Category();
        $category5->setCategoryName('Pistolet mitrailleur')
            ->setCategorySub($mainCategory)
            ->setCategoryPicture($faker->image(width: 200, height: 200));
        $manager->persist($category5);

        $category6 = new Category();
        $category6->setCategoryName("Fusil d'assaut")
            ->setCategorySub($mainCategory2)
            ->setCategoryPicture($faker->image(width: 200, height: 200));
        $manager->persist($category6);

    // Création de 100 produits

        for ($i = 0; $i < 100; $i++){
            $product = new Product();
            $product->setProductLabel($faker->word)
                ->setProductDescription($faker->sentence($nbWords = 6, $variableNbWords = true))
                ->setProductStock($faker->numberBetween($min = 0, $max = 2000))
                ->setProductPicture($faker->image(width: 100, height: 100))
                ->setProductPrice($faker->randomFloat(3, 3, 10000))
                ->setIsActive(true)
                ->setCategory($category3)
                ->setSupplier($faker->randomElement([$supplier]));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
