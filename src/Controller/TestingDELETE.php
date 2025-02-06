<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use App\Entity\User;
use App\Entity\Profile;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestingDELETE extends AbstractController
{
	#[Route('/profile', name:'profile')]
    public function loadProfile(entityManagerInterface $entityManager) {

		$targetProfile = $this->getUser();
		$targetProfile = $targetProfile->getProfile();
		// $targetProfile = $entityManager->getRepository(Profile::class)->findOneBy(['idUser' => 1]);

		// return new JsonResponse($targetProfile->toArray());
		return $this->render("navigation/profile.html.twig" , [ "targetProfile" => $targetProfile ]);
    }
	#[Route('/posts', name:'posts')]
    public function loadPosts(entityManagerInterface $entityManager) {
		$posts = array();

		// $usuario["idUser"] = "0";
		// $usuario["userName"] = "nombre";
		// $usuario["bio"] = "una biografia muy bonita";
		// $usuario["followers"] = "777";
		// $usuario["following"] = "69";

		// $post["idPost"] = "0";
		// $post["idPoster"] = $usuario;
		// $post["likes"] = "3";
		// $post["dislikes"] = "8";
		// $post["postingTime"] = "0";
		// $post["commentAmount"] = "420";
		// $post["contentRoute"] = "userData/0/posts/0.png";


		$post1 = $entityManager->getRepository(Post::class)->findOneBy(['idPost' => 1]);
		array_push($posts, $post1->getPostInfoForAJAX());
		array_push($posts, $post1->getPosterProfile()->toArray());

		// $post2 = new Post();
		// $post2->setIdPost(0);
		// $post2->setIdPoster($post1->getIdPoster());
		// $post2->setLikes(3);
		// $post2->setDislikes(8);
		// $post2->setPostingTime(0);
		// $post2->setCommentAmount(420);
		// $post2->setContentRoute("userData/0/posts/0.png");

		// array_push($posts, $post2->toArray());

		// devolver un new Response con un json para AJAX
		return new JsonResponse($posts);
    }
}