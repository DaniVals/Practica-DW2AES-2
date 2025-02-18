<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Post;
use App\Form\UserType;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/dashboard.html.twig');
    }

    // Gestión de Usuarios
    #[Route('/users', name: 'users')] public function listUsers(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        return $this->render('admin/users.html.twig', ['users' => $users]);
    }

    #[Route('/user/edit/{id}', name: 'user_edit')]
    public function editUser($id, EntityManagerInterface $entityManager): Response
    {
        // Devolver todos los datos del usuairo 
        $user = $entityManager->getRepository(User::class)->find($id);
		$profile = $user->getProfile();

		// editarlo si entra por Post
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$profile->setBio($_POST['bio']);
			$profile->setUsername($_POST['userName']);
			
			$entityManager->persist($profile);
			$entityManager->flush();
			return $this->redirectToRoute('admin_users');
		}

        return $this->render('admin/user_form.html.twig', ['user' => $user]);
    }

    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function deleteUser($id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('admin_users');
    }

    // Gestión de Posts
    #[Route('/posts', name: 'posts')]
    public function listPosts(EntityManagerInterface $entityManager): Response
    {
        $posts = $entityManager->getRepository(Post::class)->findAll();
        return $this->render('admin/posts.html.twig', ['posts' => $posts]);
    }

    #[Route('/post/edit/{id}', name: 'post_edit')]
    public function editPost(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $post = $entityManager->getRepository(Post::class)->find($id);
        return $this->render('admin/user_form.html.twig', ['user' => $post]);
    }

    #[Route('/post/delete/{id}', name: 'post_delete')]
    public function deletePost($id, EntityManagerInterface $entityManager): Response
    {
        $post = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($post);
        $entityManager->flush();
        return $this->redirectToRoute('admin_users');
    }
}
