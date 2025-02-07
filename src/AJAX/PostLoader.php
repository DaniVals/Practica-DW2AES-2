<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use App\Entity\Post;
use App\Entity\Profile;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class PostLoader extends AbstractController {
    
    #[Route('/loadPost', name:'load_post')]
    public function loadPost(EntityManagerInterface $entityManager, Request $request) {
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToRoute('feed');
        }
        $posts = $entityManager->getRepository(Post::class)->findAll();
        $post_arr = [];
        // $getWatched = $request->query->get('watched');
        foreach ($posts as $post) {
            // if ($post->getIdPost() <= $getWatched) {
            //     continue;
            // }
            $idPost = $post->getIdPost();
            $content = $post->getContent();
            $likes = $post->getLikes();
            $dislikes = $post->getDislikes();
            $postingTime = $post->getPostingTime();
            $idUser = $post->getIdUser();
            $post_arr[] = $post->getPostInfoForAJAX();
        }
        return new JsonResponse($post_arr);
    }
}
