<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignInController extends AbstractController
{

    #[Route('/signInForm', name:'load_signin')]
    public function load_signIn(){    
        return $this->render('signin.html.twig');
    }


    #[Route('/signIn', name:'crtl_signin')]
    public function signIn(UserPasswordHasherInterface $passwordHasher): Response
    {   
        // Obtenemos todos los datos del formulario a través de POST
        $email = $_POST['email'];
        $password = $_POST['password'];
        // TODO: Más info...
        $password = $passwordHasher->hashPassword($user, $password);

        // Creamos el usuario
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);

        // Aquí guardarías el usuario (EntityManager)
        // $entityManager->persist($user);
        // $entityManager->flush();
        return $this->redirectToRoute('ctrl_login');
    }    
}
