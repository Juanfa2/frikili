<?php

namespace App\Controller;

use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{

    /**
     * @Route("/", name="dashboard")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        if($user){
            $em = $this->getDoctrine()->getManager();
            $posts = $em->getRepository(Posts::class)->buscarTodosLosPosts();
            //$posts = $em->getRepository(Posts::class)->findAll(); //trae todos los datos
            /*
            $post = $em->getRepository(Posts::class)->find($id); //trae el post con id 1

            $posts = $em->getRepository(Posts::class)->findOneBy(["titulo" => "Primera publicacion"]);
            $posts = $em->getRepository(Posts::class)->findBy();
            */

            return $this->render('dashboard/index.html.twig', [
                'controller_name' => 'Bienvenido a dashboard',
                'posts' => $posts
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }


    }
}
