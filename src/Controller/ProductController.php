<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/produit', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $productRepository->findBy([],
                ['category' => 'asc'])
        ]);
    }

    #[Route('/{slug}', name: 'details')]
    public function details(Product $product): Response
    {
        return $this->render('product/details.html.twig', compact('product'));
    }
}
