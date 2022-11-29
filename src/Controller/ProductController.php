<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProductController extends AbstractController
{
    #[Route('/product', name: 'index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return $this->render('product/index.html.twig', [
            'controller_name' => 'Lakshmi',
            'id' => $product->getId(),
        ]);
    }

    #[Route('/product/create', name: 'create_product')]
    public function create(ManagerRegistry $doctrine): Response
    {
        $product = new Product();
        // $product->setName('Keyboard');
        // $product->setPrice(1999);
        // $product->setDescription('Ergonomic and stylish!');

        $form = $this->createFormBuilder($product)
        ->add('name',TextType::class)
        ->add('price',NumberType::class)
        ->add('description',TextareaType::class)
        ->add('save', SubmitType::class, ['label' =>'Add product'])
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $todo = $form->getData();

            $en = $this->getDoctrine()->getManager();
            $en->persist($product);
            $en->flush();

            return $this->redirectToRoute('index');
        }


        return $this->render('product/create.html.twig',[
            'form'=> $form->createView()
        ]);

    }
}
