<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Delivery;
use App\Entity\Note;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\Payment;
use App\Entity\Product;
use App\Entity\Supplier;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use http\Url;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordEncoder)
    {

    }

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
                ->setUserType($faker->randomElement(['1', '2']));
            $manager->persist($user);
        }

        $admin = new User();
        $admin->setEmail('admin@admin.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordEncoder->hashPassword($admin, 'bonjour'))
            ->setUserName('Fleur')
            ->setUserFirstName('Diouf')
            ->setUserAdress('1 rue de la vie')
            ->setUserCity('Paris')
            ->setUserPC('75010')
            ->setUserPhone('0632659865')
            ->setUserPicture($faker->image(width: 100, height: 100))
            ->setUserType(2);
        $manager->persist($admin);
        // Création de 8 catégories

        $mainCategory = new Category();
        $mainCategory->setCategoryName('Armes de poing')
            ->setCategoryPicture('assets/css/img/pistolet.jpg');
        $manager->persist($mainCategory);

        $mainCategory2 = new Category();
        $mainCategory2->setCategoryName("Fusils de précision")
            ->setCategoryPicture('assets/css/img/fusil_précision.jpg');
        $manager->persist($mainCategory2);

        $category3 = new Category();
        $category3->setCategoryName('Fusils à pompe')
            ->setCategorySub($mainCategory)
            ->setCategoryPicture('assets/css/img/shotgun.jpg');
        $manager->persist($category3);

        $category4 = new Category();
        $category4->setCategoryName('Pistolets mitrailleurs')
            ->setCategorySub($mainCategory)
            ->setCategoryPicture('assets/css/img/landing.jpg');
        $manager->persist($category4);

        $category5 = new Category();
        $category5->setCategoryName('Armes exotiques')
            ->setCategorySub($mainCategory)
            ->setCategoryPicture('assets/css/img/exotiques.jpg');
        $manager->persist($category5);

        $category6 = new Category();
        $category6->setCategoryName("Fusil d'assaut")
            ->setCategorySub($mainCategory2)
            ->setCategoryPicture('assets/css/img/fusils_assaut.jpg');
        $manager->persist($category6);

    // Création de 100 produits

        for ($i = 1; $i < 11; $i++){
            $product = new Product();
            $product->setProductLabel($faker->word)
                ->setProductDescription($faker->sentence($nbWords = 6, $variableNbWords = true))
                ->setProductStock($faker->numberBetween($min = 0, $max = 2000))
                ->setProductPrice($faker->randomFloat(3, 1, 1000))
                ->setIsActive(true)
                ->setCategory($faker->randomElement([$category3, $category4, $category5, $category6]))
                ->setSupplier($faker->randomElement([$supplier]));
            $this->addReference('product-' . $i, $product);
            $manager->persist($product);
        }

//        Création de 10 Order

        for ($i = 1; $i < 11; $i++){
            $order = new Order();
            $order->setOrderDate($faker->dateTime)
                ->setOrderDelivery($i)
                ->setOrderBilling($i)
                ->setOrderStatus($faker->randomElement(['En cours', 'Expédié', 'Annulée']))
                ->setUser($user);
            $this->addReference('order-'. $i, $order);
            $manager->persist($order);
        }

//        Création de 10 Payment

        for ($i = 1; $i <= mt_rand(1, 11); $i++){
            $order = $this->getReference('order-'. rand(1, 10));

            $payment = new Payment();
            $payment->setPaymentOrder($order)
                ->setPaymentMethod($faker->randomElement(['CB', 'Paypal', 'Crédit', 'Bitcoins']))
                ->setPaymentDate($faker->dateTime)
                ->setPaymentAmount($faker->randomFloat(3, 1, 20000));
            $manager->persist($payment);
        }

//        Création de 10 Delivery

        for ($i = 1; $i < 11; $i++){
            $order = $this->getReference('order-'. rand(1, 10));

            $delivery = new Delivery();
            $delivery->setDeliveryOrder($order)
                ->setDeliveryCompagny($faker->company)
                ->setDeliveryDate($faker->dateTime);
            $this->addReference('delivery-' . $i, $delivery);
            $manager->persist($delivery);
        }

//        Création de 10 Note

        for ($i = 1; $i <= mt_rand(1, 11); $i++){
            $product = $this->getReference('product-' . rand(1, 10));
            $delivery = $this->getReference('delivery-' . rand(1, 10));

            $note = new Note();
            $note->setDelivery($delivery)
                ->setProduct($product)
                ->setQuantity($faker->numberBetween(1, 100));
            $manager->persist($note);
        }

//        Création de 10 OrderDetails

        for ($i = 1; $i <= mt_rand(1, 4); $i++){
            $order = $this->getReference('order-' . rand(1, 4));
            $product = $this->getReference('product-' . rand(1, 10));

            $orderDetails = new OrderDetails();
            $orderDetails->setProduct($product)
                ->setDetailOrder($order)
                ->setDetailQuantity($faker->numberBetween(1, 100))
                ->setDetailReduction(null)
                ->setDetailUnitPrice($faker->randomFloat(3, 1, 1000));
            $manager->persist($orderDetails);
        }
        $manager->flush();
    }
}
