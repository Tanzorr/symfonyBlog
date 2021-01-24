<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;



class PostController extends AbstractController
{
    /**
     * @Route("/", name="posts")
     */
    public function index(): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/posts/{id}", name="post")
     */

    public function post($id)
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        return $this->render('post/post.html.twig', [
            'post' => $post
        ]);
    }
}
