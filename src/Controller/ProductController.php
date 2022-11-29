<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProductController extends AbstractController
{
    #[Route('/products', name: 'index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $products = $doctrine->getRepository(Product::class)
        ->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/products/create', name: 'create_product')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $product = new Product();
        $form = $this->createFormBuilder($product)
        ->add('name',TextType::class)
        ->add('price',NumberType::class)
        ->add('description',TextareaType::class)
        ->add('save', SubmitType::class, ['label' =>'Add product'])
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $todo = $form->getData();

            $en = $doctrine->getManager();
            $en->persist($product);
            $en->flush();

            return $this->redirectToRoute('index');
        }


        return $this->render('product/create.html.twig',[
            'form'=> $form->createView()
        ]);

    }

    #[Route('/product/{id}', name: 'delete_product')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $product = $doctrine->getRepository(Product::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $em = $doctrine->getManager();
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('index');
    }
}
