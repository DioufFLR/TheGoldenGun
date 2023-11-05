<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande', name: 'app_order_')]
class OrderController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function add(SessionInterface $session, ProductRepository $productRepository, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $cart = $session->get('cart', []);

        // On vérifie que le panier n'est pas vide
        if ($cart === []) {
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('app_main');
        }

        // Le panier n'est pas vide, on crée la commande
        $order = new Order();

        // On remplit la commande
        $order->setUser($this->getUser())
            ->setOrderBilling(uniqid())
            ->setOrderDelivery(uniqid())
            ->setOrderDate(new \DateTime('now'))
            ->setOrderStatus('En cours');

        // On parcourt le panier pour créer les détails de commande
        foreach ($cart as $item => $quantity) {
            $orderDetails = new OrderDetails();

            // On va chercher le produit
            $product = $productRepository->find($item);

            $price = $product->getProductPrice();

            // On crée le détail de commande
            $orderDetails->setProduct($product);
            $orderDetails->setDetailUnitPrice($price);
            $orderDetails->setDetailQuantity($quantity);

            $order->addOrderDetail($orderDetails);
        }

        // On persiste et on flush
        $entityManager->persist($order);
        $entityManager->flush();

        $session->remove('cart');

        $this->addFlash('message', 'Commande créée avec succès');


        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
