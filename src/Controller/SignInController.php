<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
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


    #[Route('/signIn', name:'ctrl_signin')]
    public function signIn(entityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {   
        $name = $_POST['_username'];
        $surname = $_POST['_surname'];
        $email = $_POST['_email'];
        $phone = $_POST['_phone'];
        $password = $_POST['_password'];
        $password2 = $_POST['_password2'];
        $bDate = $_POST['_bDate'];

        if ($this->checkSignIn($entityManager, $name, $surname, $email, $phone, $password, $password2, $bDate) != '') {
            $user = new User();
            $user->setName($name);
            $user->setSurname($surname);
            $user->setEmail($email);
            $user->setPhoneNumber($phone);
            $user->setPassword($passwordHasher->hashPassword($user, $password));
            $user->setBirthDate(new \DateTime($bDate));
            $user->getRoles();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ctrl_login');
    }   

    
    public function checkSignIn(EntityManagerInterface $entityManager, $name, $surname, $email, $phone, $password, $password2, $bDate){

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
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($user){
            return 'Email already in use';
        }
        $user = $entityManager->getRepository(User::class)->findOneBy(['phoneNumber' => $phone]);
        if ($user){
            return 'Phone already in use';
        }
        return '';
    }

}
