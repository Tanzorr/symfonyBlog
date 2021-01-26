<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

class AdmController extends AbstractController
{
    /**
     * @Route ("/dashboard", name="admin_main_page")
     */
    public function index(): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        $res = $this->denyAccessUnlessGranted('ROLE_USER');

         if($res){
             $this->redirectToRoute('main_page');
         }
        return $this->render('admin/index.html.twig', [
            'posts' => $posts

        ]);
    }
}
