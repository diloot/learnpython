<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Image;
use App\Entity\Category;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/dashboard/", name="dashboard_post_index", methods={"GET"})
     * dashboard table page
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', ['posts' => $postRepository->findAll()]);
    }

      /**
     * @Route("/dashboard/{id}", name="dashboard_post_show", methods={"GET"})
     * One post page
     */
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', ['post' => $post]);
    }

    /**
     * @Route("/dashboard/new", name="dashboard_post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('success', "Le post ".$post->getTitle()." a bien été ajouté.");

            return $this->redirectToRoute('dashboard_post_index');
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dashboard/{id}/edit", name="dashboard_post_edit", methods={"GET","POST"})
     */
    public function edit(PostRepository $postRepository, Request $request, Post $post, $id): Response
    {
        /*
        $em=$this->getDoctrine()->getManager();
        $post=$em->getRepository('App:Post')->find($id);
        if(null===$post){
            $this->addFlash('error', "Le post ".$post->getTitle()." n'existe pas.");
        }
        $listCategories=$em->getRepository('App:Category')->findAll();
        foreach($listCategories as $category) {
            $post->addCategory($category);
        }
        $em->flush();
*/
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Le post ".$post->getTitle()." a bien été modifié.");

            return $this->redirectToRoute('dashboard_post_index', ['id' => $post->getId()]);
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dashboard/{id}", name="dashboard_post_delete", methods={"DELETE"})
     */
    public function delete(PostRepository $postRepository, Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();

            $this->addFlash('success', "Le post ".$post->getTitle()." a bien été supprimé.");
        }

        return $this->redirectToRoute('dashboard_post_index');
    }
}
