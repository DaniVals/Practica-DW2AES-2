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
}