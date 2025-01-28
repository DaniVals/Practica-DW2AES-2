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
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $bDate = $_POST['bDate'];

        if (checkSignIn($name, $surname, $email, $phone, $password, $password2, $bDate) != '') {
            $user = new User();
            $user->setName($name);
            $user->setSurname($surname);
            $user->setEmail($email);
            $user->setPhone($phone);
            $user->setPassword($passwordHasher->hashPassword($user, $password));
            $user->setBDate(new \DateTime($bDate));
            $user->setRole('ROLE_USER');
            
        }

        return $this->redirectToRoute('ctrl_login');
    }   
    
    public function checkSignIn($name, $surname, $email, $phone, $password, $password2, $bDate){
        if ($password != $password2){
            return 'Passwords do not match';
        }
        
        // No se crea la cuenta tienes menos de 16 años
        $date = new \DateTime($bDate);
        $now = new \DateTime();
        $diff = $now->diff($date);
        if ($diff->y < 16){
            return 'You must be at least 16 years old to create an account';
        }

        // Si el número de telefono y el email ya pertenecen a un usuario, no se crea la cuenta
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($user){
            return 'Email already in use';
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['phone' => $phone]);
        if ($user){
            return 'Phone already in use';
        }
        return '';
    }

}
