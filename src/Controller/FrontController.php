<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Post;
use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * * @Route("/")
*/
class FrontController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * homepage
     */
    public function indexAction(PostRepository $postRepository, $page=1): Response
    {
        
        if($page<1){
            $this->addFlash('error', "La page ".$page." n'existe pas.");
        }
        $nbPerPage=5;
        $Posts=$this->getDoctrine()->getManager()->getRepository('App:Post')->findPosts($page, $nbPerPage);

        $nbPages=ceil(count($Posts)/$nbPerPage);
        if($page>$nbPages){
            $this->addFlash('error', "La page ".$page." n'existe pas.");  
        }
        return $this->render('front/index.html.twig', ['posts' => $Posts,'nbPages'=>$nbPages, 'page'=>$page]);
        //return $this->render('front/index.html.twig', ['posts' => $postRepository->findAll()]);
        //return $this->render('front/index.html.twig', ['posts' => $postRepository->findPosts()]);
    }


    /**
     * @Route("/search", name="search")
     * search results page
     */
    public function searchAction(PostRepository $postRepository): Response
    {
        return $this->render('front/search.html.twig', ['posts' => $postRepository->findAll()]);
    }

    
    /**
     * @Route("/post/{id}", name="post", requirements={"id"="\d+"}, methods={"GET"})
     * post page
     */
    public function postAction(PostRepository $postRepository, Request $request, $id): Response
    {
        $posts = $postRepository->findAll();
        $post =  $postRepository->find($id);
        return $this->render('front/post.html.twig', [
            'id' => $id,
            'post' => $post,
            'posts'=> $posts,
        ]);
    }
    
    /**
     * @Route("/category/{id}", name="category", requirements={"id"="\d+"}, methods={"GET"})
     * taxonomy page
     */
    public function categoryAction(PostRepository $postRepository, Request $request, $id=1)
    {
        if ($id == 1){
            $tagCategory = "Initiation";
        }else if ($id == 2){
            $tagCategory = "Perfectionnement";
        }else{
            $tagCategory = "category.id";
        }
        $posts = $postRepository->findAll();
        return $this->render('front/category.html.twig', [
            'id'=> $id,
            'posts' => $posts,
            'tagCategory' => $tagCategory,
        ]);
    }
}
