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

class ProfileController extends AbstractController {
    
	#[Route('/profile/{userName}', name:'load_profile')]
	public function loadProfile($userName, EntityManagerInterface $entityManager) {
		$targetProfile = $entityManager->getRepository(Profile::class)->findOneBy(['userName' => $userName]);
		return $this->render('navigation/profile.html.twig', ['targetProfile' => $targetProfile]);
	}
    #[Route('/profile', name:'redirect_profile')]
    public function redirectProfile() {
		$userName = $this->getUser();
		$userName = $userName->getProfile()->getUserName();
		return $this->redirectToRoute('load_profile', ['userName' => $userName]);
    }
}

