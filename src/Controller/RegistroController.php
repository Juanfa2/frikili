<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistroController extends AbstractController
{
    #Route
    /**
     * @Route("/registro", name="registro")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            /*
            $user->setBaneado(false);
            $user->setRoles(['ROLE_USER']);
            se creo __construct en la entidad USER y se inicializan directamente ahi.
            se inicializan porque no puede ser null, en caso de poder ser null, no se hace nada.
            */
            $user->setPassword($passwordEncoder->encodePassword($user, $form["password"]->getData()));
            $em->persist($user);
            $em->flush();
            $this->addFlash('exito', "Se ha registrado exitosamente");
            return $this->redirectToRoute('registro');
        }
        return $this->render('registro/index.html.twig', [
            'controller_name' => 'RegistroController',
            'formulario' => $form->createView()
        ]);
    }
}
