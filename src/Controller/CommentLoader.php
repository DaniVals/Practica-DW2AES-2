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


class CommentLoader extends AbstractController {
    
    #[Route('/loadComments', name:'load_comments_ajax')]
    public function loadPost(EntityManagerInterface $entityManager, Request $request) {
        // if (!$request->isXmlHttpRequest()) {
        //     return $this->redirectToRoute('feed');
        // }
		
		// $requested = $_POST['idPost'];
		$requested = 2;
        $post = $entityManager->getRepository(Post::class)->findOneBy(['idPost' => $requested]);
		$comments = $entityManager->getRepository(Comment::class)->findBy(
			['commPost' => $post],
			['postingTime' => 'ASC']
		);
		// TODO: cambiar esto si se hace bidireccional

		$comment_arr = [];
		foreach ($comments as $comment) {
			$comment_arr[] = $comment->getCommentInfoForAJAX();
		}

        return new JsonResponse($comment_arr);
    }
}
