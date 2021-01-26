<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends AbstractController
{
    /**
     * @Route("/comments", name="comments")
     */
    public function index(): Response
    {
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findAll();

        return $this->render('admin/comments.html.twig', [
            'comments' => $comments,
        ]);
    }

    /**
     * @Route ("comment/add/{postId}",  name="add_comment")
     */

    public function addComment(Post $postId, Request $request)
    {
       $user =  $this->getUser();
       if (!empty(trim($request->request->get('comment'))))
        {
            $comment = new Comment();
            $comment->setContent($request->request->get('comment'));
            if($user) {
                $comment->setRelation($user);
            }else{
                $comment->setRelation(null);
            }
            $comment->setUpruwed(null);
            $comment->setPost($postId);
            $comment->setCreatedAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
        }
       return $this->redirectToRoute('post',['id'=>$postId->getId()]);
    }

    /**
     * @Route ("comment/{id}",  name="view_comment")
     */

    public function getComment($id)
    {
        $comment = $this->getDoctrine()->getRepository(Comment::class)->find($id);
        return $this->render('comment/comment.html.twig',[
            'comment'=>$comment
        ]);
    }

    /**
     * @Route ("comment/approve/{id}",  name="approve_comment")
     */

    public function approveComement(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $comment->setUpruwed(true);
        $em->persist($comment);
        $em->flush();
        return $this->redirectToRoute('comments');
    }

    /**
     * @Route ("comment/hide/{id}",  name="hide_comment")
     */

    public function hideComement(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $comment->setUpruwed(false);
        $em->persist($comment);
        $em->flush();
        return $this->redirectToRoute('comments');
    }


    /**
     * @Route ("comment/delete/{id}",  name="delete_comment")
     */

    public function deleteComment(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();
        return $this->redirectToRoute('comments');
    }
}
