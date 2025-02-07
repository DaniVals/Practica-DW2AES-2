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

class  FeedController extends AbstractController {
    #[Route('/', name:'root')]
    public function feed() {   
        return $this->redirectToRoute('feed');
    }

    #[Route('/feed', name:'feed')]
    public function load_feed() {   
        return $this->render('navigation/feed.html.twig');
    }

    #[Route('/feed/{idPost}', name:'load_post')]
    public function load_post($idPost, EntityManagerInterface $entityManager) {

		$targetPost = $entityManager->getRepository(Post::class)->findOneBy(['idPost' => $idPost]);

        return $this->render('navigation/post.html.twig', ['targetPost' => $targetPost]);
    }

    #[Route('/feed/{idPost}/comment', name:'load_comments')]
    public function load_comments($idPost, EntityManagerInterface $entityManager) {   
        // Leer de la bbdd los comentario de un post y almacenarlos en un array
        $comments_arr = [];
        $comments = $entityManager->getRepository(Comment::class)->findBy(['commentedComment' => $idPost]);
        foreach ($comments as $comment) {
            // $user = $entityManager->getRepository(User::class)->findOneBy(['idUser' => $comment->getIdUser()]);
            $content = $comment->getContent();
            $likes = $comment->getLikes();
            $dislikes = $comment->getDislikes();
            $postTime = $comment->getPostingTime();
            $user = 1;
            $comments_arr[] = ['user' => $user, 'content' => $content, 'likes' => $likes, 'dislikes' => $dislikes, 'postingTime' => $postTime];
        }

        return new Response(JSON_encode($comments_arr));

        return $this->render('navigation/comments.html.twig', ['idPost' => $idPost, 'comments' => $comments]);
    }
}
