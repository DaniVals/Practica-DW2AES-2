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

class UserFinderController extends AbstractController {

    #[Route('/find/{username}', name:'load_user')]
    public function load_user($username, EntityManagerInterface $entityManager) {
        $targetProfile = $entityManager->getRepository(Profile::class)->findOneBy(['userName' => $username]);
        return $this->render('navigation/profile.html.twig', ['targetProfile' => $targetProfile]);
    }
}
