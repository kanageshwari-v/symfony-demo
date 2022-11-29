<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ProductValidateController extends AbstractController
{
    #[Route('/product-validate', name: 'app_product_validate')]
    public function index(ValidatorInterface $validator): Response
    {

        $product = new Product();
        // This will trigger an error: the column isn't nullable in the database
        $product->setName(null);
        // This will trigger a type mismatch error: an integer is expected
        $product->setPrice('1999');

        // ...

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }    
    }
}
