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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


class AppFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $passwordEncoder, private SluggerInterface $slugger)
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
        // Parents
        $parentCategory = new Category();
        $parentCategory->setCategoryName("Armes d'épaule")
            ->setCategoryPicture('assets/css/img/fusil_précision.jpg')
            ->setCategorySub(null)
            ->setCategoryDescription("Une arme d'épaule est une arme à feu qui est épaulée (tenue à l'épaule) pendant le tir.");
        $manager->persist($parentCategory);

        $parentCategory2 = new Category();
        $parentCategory2->setCategoryName('Armes de poing')
            ->setCategoryPicture('assets/css/img/pistolet.jpg')
            ->setCategorySub(null)
            ->setCategoryDescription("Une arme de poing est une arme qui peut se définir comme non destinée à être épaulée. Par conséquent, elle peut s'utiliser avec une seule main. ");
        $manager->persist($parentCategory2);

        $parentCategory3 = new Category();
        $parentCategory3->setCategoryName('Armes exotiques')
            ->setCategoryPicture("https://www.francearcherie.com/images/Image/Booster-Arc-XH-30-1-RTH-55M042-3-1.jpg")
            ->setCategorySub(null)
            ->setCategoryDescription("Les armes exotiques sont toutes les armes qui ne rentrent pas dans les deux premières grandes catégorie");
        $manager->persist($parentCategory3);

        // Sous-catégories
        $category = new Category();
        $category->setCategoryName("Fusils de précision")
            ->setCategoryPicture('assets/css/img/fusil_précision.jpg')
            ->setCategorySub($parentCategory2);
        $manager->persist($category);

        $category2 = new Category();
        $category2->setCategoryName('Lanceurs')
            ->setCategorySub($parentCategory3)
            ->setCategoryPicture('assets/css/img/shotgun.jpg');
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setCategoryName('Fusils à pompe')
            ->setCategorySub($parentCategory)
            ->setCategoryPicture('assets/css/img/shotgun.jpg');
        $manager->persist($category3);

        $category4 = new Category();
        $category4->setCategoryName('Pistolets mitrailleurs')
            ->setCategorySub($parentCategory2)
            ->setCategoryPicture('assets/css/img/landing.jpg');
        $manager->persist($category4);

        $category5 = new Category();
        $category5->setCategoryName('Pistolets et Revolvers')
            ->setCategorySub($parentCategory2)
            ->setCategoryPicture('assets/css/img/landing.jpg');
        $manager->persist($category5);

        $category6 = new Category();
        $category6->setCategoryName("Fusil d'assaut")
            ->setCategorySub($parentCategory)
            ->setCategoryPicture('assets/css/img/fusils_assaut.jpg');
        $manager->persist($category6);

        // Création de 100 produits

//        for ($i = 1; $i < 11; $i++){
//            $product = new Product();
//            $product->setProductLabel($faker->word)
//                ->setProductDescription($faker->sentence($nbWords = 6, $variableNbWords = true))
//                ->setProductStock($faker->numberBetween($min = 0, $max = 2000))
//                ->setProductPrice($faker->randomFloat(3, 1, 1000))
//                ->setIsActive(true)
//                ->setSlug($this->slugger->slug($product->getProductLabel())->lower())
//                ->setCategory($faker->randomElement([$category3, $category4, $category5, $category6]))
//                ->setSupplier($faker->randomElement([$supplier]));
//            $this->addReference('product-' . $i, $product);
//            $manager->persist($product);
//        }

        $product = new Product();
        $product->setProductLabel('HK 416')
            ->setProductDescription("Fusil au calibre Otan 5,56 mm, le HK 416 F dispose d'une crosse réglable et de talons de crosse permettant de s'adapter à la morphologie de chaque tireur. Disposant d'une autonomie accrue, le combattant sera muni de 10 chargeurs de 30 cartouches . ")
            ->setProductStock(300)
            ->setProductPrice(700)
            ->setIsActive(1)
            ->setSlug($this->slugger->slug($product->getProductLabel())->lower())
            ->setSupplier($supplier)
            ->setCategory($category6);
        $manager->persist($product);

        $product2 = new Product();
        $product2->setProductLabel('AR 15')
            ->setProductDescription("Le fusil d'assaut AR-15 a été créé en 1959 par l'Américain Eugene Stoner. Il s'appelle ainsi en référence aux premières lettres du nom de la société qui a en premier conçu le fusil : Armalite Rifle")
            ->setProductStock(120)
            ->setProductPrice(650)
            ->setIsActive(1)
            ->setSlug($this->slugger->slug($product->getProductLabel())->lower())
            ->setSupplier($supplier)
            ->setCategory($category6);
        $manager->persist($product2);

        $product3 = new Product();
        $product3->setProductLabel('Glock 17')
            ->setProductDescription("Un Glock 17 est noir, sa forme rectangulaire. Il est compact, facile à avoir bien en main grâce à sa crosse qui s'adapte à la paume. Depuis la troisième génération, des rainures ont été ajoutées pour rendre sa stabilité plus importante.")
            ->setProductStock(56)
            ->setProductPrice(599)
            ->setIsActive(1)
            ->setSlug($this->slugger->slug($product->getProductLabel())->lower())
            ->setSupplier($supplier)
            ->setCategory($category5);
        $manager->persist($product3);

        $product4 = new Product();
        $product4->setProductLabel('Glock 21')
            ->setProductDescription("Le pistolet Glock 21 Gen4 est une arme de poing de la gamme Glock capable de tirer la munition de . 45 ACP, délivrant ainsi un pouvoir d'arrêt considérable. ")
            ->setProductStock(200)
            ->setProductPrice(450)
            ->setIsActive(1)
            ->setSlug($this->slugger->slug($product->getProductLabel())->lower())
            ->setSupplier($supplier)
            ->setCategory($category5);
        $manager->persist($product4);

        $product5 = new Product();
        $product5->setProductLabel('Remington 870')
            ->setProductDescription("abriqué aux Etats-Unis, le fusil à pompe Remington 870 Express Bois présente toute la qualité d'une arme à carcasse d'acier et à fonctionnement éprouvé. ")
            ->setProductStock(300)
            ->setProductPrice(1000)
            ->setIsActive(1)
            ->setSlug($this->slugger->slug($product->getProductLabel())->lower())
            ->setSupplier($supplier)
            ->setCategory($category3);
        $manager->persist($product5);

        $product6 = new Product();
        $product6->setProductLabel('Spas 12')
            ->setProductDescription("Le SPAS 12, doté d'un canon à âme lisse, tire des cartouches de calibre 12/70mm et dispose d'un magasin tubulaire. Semi-automatique, il fonctionne également en chargement manuel. ")
            ->setProductStock(51)
            ->setProductPrice(1200)
            ->setIsActive(1)
            ->setSlug($this->slugger->slug($product->getProductLabel())->lower())
            ->setSupplier($supplier)
            ->setCategory($category3);
        $manager->persist($product6);

        $product7 = new Product();
        $product7->setProductLabel('rpg-7')
            ->setProductDescription("Le RPG-7 (en russe : ручной противотанковый гранатомёт, routchnoy protivotankovy granatamiot, « lance-grenades antichar manuel ») est un lance-grenade propulsé par roquette non guidée, antichar, portatif et réutilisable. ")
            ->setProductStock(12)
            ->setProductPrice(500)
            ->setIsActive(1)
            ->setSlug($this->slugger->slug($product->getProductLabel())->lower())
            ->setSupplier($supplier)
            ->setCategory($category6);
        $manager->persist($product7);

        $product8 = new Product();
        $product8->setProductLabel('FR-F2')
            ->setProductDescription("Le FR-F2 (Fusil à Répétition modèle F2) est un fusil de précision en usage dans l'Armée française depuis 1986, produit par la Manufacture d'armes de Saint-Etienne. ")
            ->setProductStock(300)
            ->setProductPrice(700)
            ->setIsActive(1)
            ->setSlug($this->slugger->slug($product->getProductLabel())->lower())
            ->setSupplier($supplier)
            ->setCategory($category);
        $manager->persist($product8);

        $product9 = new Product();
        $product9->setProductLabel('MP5')
            ->setProductDescription("e MP5 est un pistolet mitrailleur chambré initialement en 9x19mm mais existant aussi en 10mm Auto et 40 S&W, célèbre dans le monde entier puisqu'il équipe bon nombre de forces spéciales et de polices. ")
            ->setProductStock(45)
            ->setProductPrice(850)
            ->setIsActive(1)
            ->setSlug($this->slugger->slug($product->getProductLabel())->lower())
            ->setSupplier($supplier)
            ->setCategory($category4);
        $manager->persist($product9);

//        Création de 10 Order

//        for ($i = 1; $i < 11; $i++){
//            $order = new Order();
//            $order->setOrderDate($faker->dateTime)
//                ->setOrderDelivery($i)
//                ->setOrderBilling($i)
//                ->setOrderStatus($faker->randomElement(['En cours', 'Expédié', 'Annulée']))
//                ->setUser($user);
//            $this->addReference('order - '. $i, $order);
//            $manager->persist($order);
//        }
//
////        Création de 10 Payment
//
//        for ($i = 1; $i <= mt_rand(1, 11); $i++){
//            $order = $this->getReference('order - '. rand(1, 10));
//
//            $payment = new Payment();
//            $payment->setPaymentOrder($order)
//                ->setPaymentMethod($faker->randomElement(['CB', 'Paypal', 'Crédit', 'Bitcoins']))
//                ->setPaymentDate($faker->dateTime)
//                ->setPaymentAmount($faker->randomFloat(3, 1, 20000));
//            $manager->persist($payment);
//        }
//
////        Création de 10 Delivery
//
//        for ($i = 1; $i < 11; $i++){
//            $order = $this->getReference('order - '. rand(1, 10));
//
//            $delivery = new Delivery();
//            $delivery->setDeliveryOrder($order)
//                ->setDeliveryCompagny($faker->company)
//                ->setDeliveryDate($faker->dateTime);
//            $this->addReference('delivery - ' . $i, $delivery);
//            $manager->persist($delivery);
//        }
//
////        Création de 10 Note
//
//        for ($i = 1; $i <= mt_rand(1, 11); $i++){
//            $product = $this->getReference('product - ' . rand(1, 10));
//            $delivery = $this->getReference('delivery - ' . rand(1, 10));
//
//            $note = new Note();
//            $note->setDelivery($delivery)
//                ->setProduct($product)
//                ->setQuantity($faker->numberBetween(1, 100));
//            $manager->persist($note);
//        }
//
////        Création de 10 OrderDetails
//
//        for ($i = 1; $i <= mt_rand(1, 4); $i++){
//            $order = $this->getReference('order - ' . rand(1, 4));
//            $product = $this->getReference('product - ' . rand(1, 10));
//
//            $orderDetails = new OrderDetails();
//            $orderDetails->setProduct($product)
//                ->setDetailOrder($order)
//                ->setDetailQuantity($faker->numberBetween(1, 100))
//                ->setDetailReduction(null)
//                ->setDetailUnitPrice($faker->randomFloat(3, 1, 1000));
//            $manager->persist($orderDetails);
//        }
        $manager->flush();
    }
}
