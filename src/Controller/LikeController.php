<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use App\Entity\Post;
use App\Entity\Profile;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LikeController extends AbstractController {

    // Cada vez que se escriba una letra, JS hará una petición al servidor para buscar usuarios que coincidan con la o las letras
    // Se mostrará una lista de usuarios que empiezen con la o las letras
    #[Route('/reactPost/{whichReaction}/{postId}', name:'react_to_post_AJAX')]
    public function react_to_post($whichReaction, $postId, EntityManagerInterface $entityManager, Request $request) {

		$post = $entityManager->getRepository(Post::class)->findOneBy(['idPost' => $postId]);
		
		$response = [
			"reaction" => "",
			"newLikes" => "",
			"newDislikes" => "",
		];

		switch ($whichReaction) {

			// 0 is a Like
			case '0':
				$post->setLikes($post->getLikes() + 1);
				$response["reaction"] = "Like";
				break;
			
			// 1 is Dislike
			case '1':
				$post->setDislikes($post->getDislikes() + 1);
				$response["reaction"] = "Dislike";
				break;

			// 0 is a Like
			case '2':
				$post->setLikes($post->getLikes() - 1);
				$response["reaction"] = "Remove Like";
				break;
			
			// 1 is Dislike
			case '3':
				$post->setDislikes($post->getDislikes() - 1);
				$response["reaction"] = "Remove Dislike";
				break;

			default:
				break;
		}

		$entityManager->persist($post);
		$entityManager->flush();

		$response["newLikes"] = $post->getLikes();
		$response["newDislikes"] = $post->getDislikes();
		
        return new JsonResponse($response);  
    }
}
