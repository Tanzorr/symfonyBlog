<?php

namespace App\Controller;

use App\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\User;


class PostController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
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
        $author =  $post->getCreatedBy();

        return $this->render('post/post.html.twig', [
            'author'=>$author,
            'post' => $post
        ]);
    }


    /**
     * @Route("/post/add", name="addPost")
     */

    public function addPost(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $author = $this->getUser();
            $entityManager = $this->getDoctrine()->getManager();
            $post->setCreatedData(new \DateTime());
            $post->setCreatedBy($author);
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('admin_main_page');
        }
        return $this->render('post/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/post/edit/{id}", name="edit_post")
     */

    public function editPost(Request $request, Post $post)
    {

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $author = $this->getUser();
            $entityManager = $this->getDoctrine()->getManager();
            $post->setTitle($request->request->get('post')['title']);
            $post->setDescription($request->request->get('post')['description']);
            $post->setText($request->request->get('post')['text']);
            $post->setCreatedData(new \DateTime());
            $post->setCreatedBy($author);
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('admin_main_page');
        }
        return $this->render('post/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/post/delete/{id}", name="delete_post")
     */

    public function deletePost($id)
    {
        $existinPost = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($existinPost);
        $entityManager->flush();
        return $this->redirectToRoute('admin_main_page');
    }
}
