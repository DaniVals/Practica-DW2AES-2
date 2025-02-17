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
        // // Leer de la bbdd los comentario de un post y almacenarlos en un array
        // $comments_arr = [];
        // $comments = $entityManager->getRepository(Comment::class)->findBy(['commentedComment' => $idPost]);
        // foreach ($comments as $comment) {
        //     // $user = $entityManager->getRepository(User::class)->findOneBy(['idUser' => $comment->getIdUser()]);
        //     $content = $comment->getContent();
        //     $likes = $comment->getLikes();
        //     $dislikes = $comment->getDislikes();
        //     $postTime = $comment->getPostingTime();
        //     $user = 1;
        //     $comments_arr[] = ['user' => $user, 'content' => $content, 'likes' => $likes, 'dislikes' => $dislikes, 'postingTime' => $postTime];
        // }

        // return new Response(JSON_encode($comments_arr));

        return $this->render('navigation/comments.html.twig', ['idPost' => $idPost]);
    }

    #[Route('/newPost', name:'new_post')]
    public function new_post(EntityManagerInterface $entityManager) {
		
		$user = $this->getUser();
		$posterProfile = $user->getProfile();

		$error = "";

		// procesar formulario por post
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($_FILES['postPhoto']['error'] == UPLOAD_ERR_OK) {
			
				$newPost = new Post();
				$newPost->setLikes(0);
				$newPost->setDislikes(0);
				$newPost->setCommentAmount(0);
				$newPost->setPostingTime(new \DateTimeImmutable());
				$newPost->setPosterProfile($posterProfile);
				$newPost->setContentRoute("");

				// subimos el post para que tenga una id
				$entityManager->persist($newPost);
				$entityManager->flush();
				
				$filePath = 'userData'.'/' . $posterProfile->getIdUser() . '/posts'.'/' . $newPost->getIdPost() .'.png';
				move_uploaded_file($_FILES['postPhoto']['tmp_name'], $filePath);
				$newPost->setContentRoute('/'.$filePath);

				$entityManager->persist($newPost);
				$entityManager->flush();
				
				return $this->redirectToRoute('load_post', ['idPost' => $newPost->getIdPost()]);
			}else {
				$error .= "Sube una imagen ";
			}
		}

        return $this->render('navigation/postCreate.html.twig', ["error" => $error]);
    }

    #[Route('/newComment/{post}/{comment}', name:'new_comment')]
    public function new_comment($post, $comment, EntityManagerInterface $entityManager) {
		
		$user = $this->getUser();
		$posterProfile = $user->getProfile();

		$post = $entityManager->getRepository(Post::class)->findOneBy(['idPost' => $post]);

		// procesar formulario por post
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$newComment = new Comment();
			$newComment->setLikes(0);
			$newComment->setDislikes(0);
			$newComment->setPostingTime(new \DateTimeImmutable());
			$newComment->setProfileUser($posterProfile);
			$newComment->setContent($_POST['commentText']);
			$newComment->setCommPost($post);

			if ($comment < 0) {
				$newComment->setCommComment(null);
			}else {
				$newComment->setCommComment($entityManager->getRepository(Comment::class)->findOneBy(['idComment' => $comment]));
			}

			$entityManager->persist($newComment);
			$entityManager->flush();

			// recontar el numero de comentarios
			$post->recountComments($entityManager);
		}

        return $this->redirectToRoute('load_comments', ['idPost' => $post->getIdPost()]);
    }
	
    #[Route('/following', name:'feed_mutuals')]
    public function load_feed_mutuals() {
        return $this->render('navigation/feedFriends.html.twig');
    }
}
