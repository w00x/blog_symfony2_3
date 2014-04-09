<?php

namespace Blas\BlogBundle\Controller;

use Blas\BlogBundle\Entity\Comment;
use Blas\BlogBundle\Entity\Post;
use Blas\BlogBundle\Form\CommentType;
use Blas\BlogBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function indexAction(Request $request) {
        $post = new Post();
        $form = $this->createForm(new PostType(), $post);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $form = $this->createForm(new PostType(), new Post());

        }

        $doctrine = $this->getDoctrine();
        $post_repo = $doctrine->getRepository('BlasBlogBundle:Post');
        $posts = $post_repo->findAll();

        return $this->render('BlasBlogBundle:Main:index.html.twig',array(
                            'form' => $form->createView(),
                            'posts' => $posts
                        ));
    }

    public function commentsAction(Post $post) {
        $request = $this->getRequest();
        $comment = new Comment();

        $form = $this->createForm(new CommentType(), $comment);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $form = $this->createForm(new CommentType(), new Comment());

                $comment->setPost($post);
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
            }
        }

        return $this->render('BlasBlogBundle:Main:comments.html.twig',array(
                                'post' => $post,
                                'form' => $form->createView()
                            ));
    }
}
