<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductFetchController extends AbstractController
{
    #[Route('/product/{id}', name: 'app_product_fetch')]
    public function index(ManagerRegistry $doctrine, int $id): Response
    {
        $product = $doctrine->getRepository(Product::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        return $this->render('product_fetch/index.html.twig', [
            'controller_name' => 'ProductFetchController',
            'product_name' => $product->getName(),
        ]);
    }
}
