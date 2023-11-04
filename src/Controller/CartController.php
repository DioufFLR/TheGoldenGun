<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use PharIo\Version\AbstractVersionConstraint;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProductRepository $productRepository)
    {
        $cart = $session->get('cart', []);

        // On initialise des variables
        $data = [];
        $total = 0;

        foreach($cart as $id => $quantity) {
            $product = $productRepository->find($id);

            $data[] = [
                'product' => $product,
                'quantity' => $quantity
            ];
            $total += $product->getProductPrice() * $quantity;
        }

        return $this->render('cart/index.html.twig', compact('data', 'total'));
    }
    #[Route('/ajout/{id}', name: 'add')]
    public function add(Product $product, SessionInterface $session)
    {
        // On récupère l'id du produit
        $id = $product->getId();

        // On récupère le panier existant s'il existe
        $cart = $session->get('cart', []);

        // On ajoute le produit dans le panier s'il n'y est pas encore
        // Sinon on incrémente sa quantité
        if(empty($cart[$id])) {
            $cart[$id] = 1;
        } else {
            $cart[$id]++;
        }

        $session->set('cart', $cart);

        // On redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }
}