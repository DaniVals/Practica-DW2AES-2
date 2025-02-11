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
use App\Entity\Comment;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestingDELETE extends AbstractController
{
	// #[Route('/profile', name:'profile')]
    // public function loadProfile(entityManagerInterface $entityManager) {

	// 	$targetProfile = $this->getUser();
	// 	// $targetProfile = $targetProfile->getProfile();
	// 	// $targetProfile = $entityManager->getRepository(Profile::class)->findOneBy(['idUser' => 1]);

	// 	// return new JsonResponse($targetProfile->toArray());
	// 	return $this->render("navigation/profile.html.twig" , [ "targetProfile" => $targetProfile ]);
    // }
	#[Route('/comment/view', name:'comment')]
    public function loadComment(entityManagerInterface $entityManager) {
		$comments = array();

		$post1 = $entityManager->getRepository(Comment::class)->findOneBy(['idComment' => 1]);
		array_push($comments, $post1->toArray());
		// $post2 = $entityManager->getRepository(Comment::class)->findOneBy(['idComment' => 2]);
		// array_push($comments, $post2->toArray());

		return new JsonResponse($comments);
    }
}