<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Delivery;
use App\Entity\Note;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\Payment;
use App\Entity\Product;
use App\Entity\Supplier;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TheGoldenGun');
    }

    public function configureMenuItems(): iterable
    {
         yield MenuItem::linkToCrud('Produits', 'fa-regular fa-registered', Product::class);
         yield MenuItem::linkToCrud('Categories', 'fa-solid fa-shield-cat', Category::class);
         yield MenuItem::linkToCrud('Livraisons', 'fa-solid fa-truck', Delivery::class);
         yield MenuItem::linkToCrud('Commandes', 'fa-solid fa-cart-plus', Order::class);
         yield MenuItem::linkToCrud('Détail commandes', 'fas fa-book', OrderDetails::class);
        yield MenuItem::linkToCrud('Bons', 'fa-solid fa-note-sticky', Note::class);
        yield MenuItem::linkToCrud('Paiements', 'fa-regular fa-credit-card', Payment::class);
         yield MenuItem::linkToCrud('Fournisseurs', 'fa-solid fa-user-secret', Supplier::class);
         yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
    }
}
