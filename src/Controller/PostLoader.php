<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use App\Entity\Post;
use App\Entity\Profile;
use App\Entity\Friendship;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class PostLoader extends AbstractController {

    #[Route('/loadPost', name: 'load_post_ajax')]
    public function loadPost(EntityManagerInterface $entityManager, Request $request): JsonResponse {
        // Verificar si la solicitud es AJAX
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToRoute('feed');
        }

        // Obtener los posts ordenados por fecha (postingTime) de manera descendente
        $posts = $entityManager->getRepository(Post::class)
            ->createQueryBuilder('p')
            ->orderBy('p.postingTime', 'DESC') // Ordenar por fecha descendente
            ->getQuery()
            ->getResult();

        $post_arr = [];
        foreach ($posts as $post) {
            $post_arr[] = $post->getPostInfoForAJAX();
        }

        return new JsonResponse($post_arr);
    }

    #[Route('/loadPost/timeline', name: 'load_post_timeline_ajax')]
    public function loadPostTimeline(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToRoute('feed');
        }

        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'User not authenticated'], Response::HTTP_UNAUTHORIZED);
        }

        // Obtener los IDs de los amigos confirmados
        $friends = $entityManager->createQueryBuilder()
            ->select('CASE 
                WHEN f.IdRequestor = :userId THEN u2.idUser
                ELSE u1.idUser
                END as friendId')
            ->from(Friendship::class, 'f')
            ->leftJoin('f.IdRequestor', 'u1')
            ->leftJoin('f.IdRequested', 'u2')
            ->where('(f.IdRequestor = :userId)')
            ->andWhere('f.frState = 2')  
            ->setParameter('userId', $this->getUser())
            ->getQuery()
            ->getResult();

        $friendIds = array_column($friends, 'friendId');

        if (empty($friendIds)) {
            return new JsonResponse([]);
        }

        // Obtener los posts de los amigos confirmados
        $posts = $entityManager->createQueryBuilder()
            ->select('p')
            ->from(Post::class, 'p')
            ->where('p.PosterProfile IN (:friendIds)')
            ->setParameter('friendIds', $friendIds)
            ->orderBy('p.postingTime', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        $post_arr = [];
        foreach ($posts as $post) {
            $post_arr[] = $post->getPostInfoForAJAX();
        }

        return new JsonResponse($post_arr);
    }

    #[Route('/loadPost/user/{userId}', name:'load_post_user_ajax')]
    public function loadPostUser($userId, EntityManagerInterface $entityManager, Request $request) {
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToRoute('feed');
        }
        $profile = $entityManager->getRepository(Profile::class)->findOneBy(['idUser' => $userId]);
        $posts = $entityManager->getRepository(Post::class)->findBy(['PosterProfile' => $profile]);
        $post_arr = [];
        // $getWatched = $request->query->get('watched');
        foreach ($posts as $post) {
            // if ($post->getIdPost() <= $getWatched) {
            //     continue;
            // }
            $post_arr[] = $post->getPostInfoForAJAX();
        }
        return new JsonResponse($post_arr);
    }
}
