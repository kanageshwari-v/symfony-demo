<?php

namespace App\Controller;

use App\Entity\employeescontroller;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class employeescontroller extends AbstractController
{
    #[Route('/employees', name: 'index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $employees = $doctrine->getRepository(employees::class)
        ->findAll();

        return $this->render('employees/index.html.twig', [
            'employees' => $employeesdetails,
        ]);
    }

    #[Route('/employees/create', name: 'create_employees')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $employees = new employees();
        $form = $this->createFormBuilder($employees)
        ->add('name',TextType::class)
        ->add('salary',NumberType::class)
        ->add('destination',TextareaType::class)
        ->add('save', SubmitType::class, ['label' =>'Add employees'])
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $todo = $form->getData();

            $en = $doctrine->getManager();
            $en->persist($employees);
            $en->flush();

            return $this->redirectToRoute('index');
        }


        return $this->render('employees/create.html.twig',[
            'form'=> $form->createView()
        ]);

    }

    #[Route('/employees/{id}', name: 'delete_employees')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $employees = $doctrine->getRepository(employees::class)->find($id);
        if (!$employees) {
            throw $this->createNotFoundException(
                'No employees found for id '.$id
            );
        }
        $em = $doctrine->getManager();
        $em->remove($employees);
        $em->flush();
        return $this->redirectToRoute('index');
    }
}
