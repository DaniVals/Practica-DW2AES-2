<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use App\Entity\Post;
use App\Entity\Profile;
use App\Entity\Comment;
use App\Entity\Friendship;
use App\Entity\State;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController {
    
	#[Route('/profile/{userName}', name:'load_profile')]
	public function loadProfile($userName, EntityManagerInterface $entityManager) {

		$userProfile = $this->getUser();
		$targetProfile = $entityManager->getRepository(Profile::class)->findOneBy(['userName' => $userName]);

		$relationship = $entityManager->getRepository(Friendship::class)->findOneBy(['IdRequestor' => $userProfile, 'IdRequested' => $targetProfile->getUser()]);

		$relationshipState = "NULO";
		if ($relationship != null) {
			$relationshipState = $relationship->getFrState()->getName();
		}

		return $this->render('navigation/profile.html.twig', ['targetProfile' => $targetProfile, 'relationshipState' => $relationshipState]);
	}
	#[Route('/profile/{userName}/friendRequest/{newState}', name:'friend_profile')]
	public function sendFriendRequest($userName, $newState, EntityManagerInterface $entityManager) {

		$targetUser = $entityManager->getRepository(Profile::class)->findOneBy(['userName' => $userName])->getUser();
		$pendingState = $entityManager->getRepository(State::class)->findOneBy(['idState' => $newState]);
		
		$userUser = $this->getUser();

		$friendRequest = $entityManager->getRepository(Friendship::class)->findOneBy(['IdRequestor' => $userUser, 'IdRequested' => $targetUser]);

		if ($friendRequest != null) {
			$friendRequest->setFrState($pendingState);
			
		}else {
			$friendRequest = new Friendship();
			$friendRequest->setUserRequestor($userUser);
			$friendRequest->setUserRequested($targetUser);
			$friendRequest->setFrDate(new \DateTime());
			$friendRequest->setFrState($pendingState);
		}

		$entityManager->persist($friendRequest);
		$entityManager->flush();

		return $this->redirectToRoute('load_profile', ['userName' => $userName]);
	}
    #[Route('/profile', name:'redirect_profile')]
    public function redirectProfile() {
		$userName = $this->getUser();
		$userName = $userName->getProfile()->getUserName();
		return $this->redirectToRoute('load_profile', ['userName' => $userName]);
    }
    #[Route('/profileEdit', name:'edit_profile')]
    public function editProfile(EntityManagerInterface $entityManager) {
		$user = $this->getUser();
		$targetProfile = $user->getProfile();
		
		$error = "";
		
		// procesar formulario por post
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			// NUEVO NOMBRE DE USUARIO
			$newUserName = $_POST['username'];
			$namedProfile = $entityManager->getRepository(Profile::class)->findOneBy(['userName' => $newUserName]);
			
			if ($namedProfile != null && $namedProfile->getIdUser() != $user->getIdUser()) {
				// \Doctrine\DBAL\Exception\UniqueConstraintViolationException
				$error .= "El nombre de usuario ya está en uso ";
			}else {
				$targetProfile->setUserName($newUserName);
			}
			
			// NUEVA BIOGRAFIA
			$targetProfile->setBio($_POST['bio']);
			
			// NUEVA FOTO DE PERFIL
			// guardar foto en la carpeta public/userData
			if ($_FILES['profilePicture']['error'] == UPLOAD_ERR_OK) {
				$filePath = 'userData/' . $targetProfile->getIdUser() . '/ProfilePicture.png';
				move_uploaded_file($_FILES['profilePicture']['tmp_name'], $filePath);
			}else {
				// $error .= "Error al subir la imagen ";
			}
			
			$entityManager->persist($targetProfile);
			$entityManager->flush();

			// que devuelva al formulario con un codigo de error exitoso
			if ($error == "") {
				$error = "Se ha actualizado el perfil correctamente";
			}
		}

		return $this->render('navigation/profileEdit.html.twig', ['targetProfile' => $targetProfile, "error" => $error]);
    }
}
