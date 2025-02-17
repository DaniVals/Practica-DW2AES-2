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

class UserFinderController extends AbstractController {

    #[Route('/find', name:'load_finder')]
    public function load_finder(EntityManagerInterface $entityManager) {
        $users = $entityManager->getRepository(User::class)->findAll();
        return $this->render('navigation/find_user.html.twig', ['users' => $users]);
    }

    // Cada vez que se escriba una letra, JS hará una petición al servidor para buscar usuarios que coincidan con la o las letras
    // Se mostrará una lista de usuarios que empiezen con la o las letras
    #[Route('/findAJAX', name:'find_user_AJAX')]
    public function find_user(EntityManagerInterface $entityManager, Request $request) {
        // Devolver un JSON con los usuarios que coincidan con la búsqueda
        $search = $request->get('search');
        $profiles = $entityManager->getRepository(Profile::class)->createQueryBuilder('u')
            ->where('u.userName LIKE :search')
            ->setParameter('search', $search . '%')
            ->getQuery()
            ->getResult();
        $usernames = [];
        foreach ($profiles as $profile) {
            $usernames[] = $profile->toArray();
        }
        return new JsonResponse($usernames);  
    }

    #[Route('/find/{username}', name:'load_user')]
    public function load_user($username, EntityManagerInterface $entityManager) {
        $targetProfile = $entityManager->getRepository(Profile::class)->findOneBy(['userName' => $username]);
        return $this->render('navigation/profile.html.twig', ['targetProfile' => $targetProfile]);
    }
}
