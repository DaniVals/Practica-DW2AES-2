<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use App\Entity\Profile;
use App\Entity\Accactivation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignInController extends AbstractController
{
    #[Route('/signInForm', name:'load_signin')]
    public function load_signIn(){    
        return $this->render('accManagment/signin.html.twig');
    }


    #[Route('/signIn', name:'ctrl_signin')]
    public function signIn(entityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {   
        $username = $_POST['_user'];
        $name = $_POST['_username'];
        $surname = $_POST['_surname'];
        $email = $_POST['_email'];
        $phone = $_POST['_phone'];
        $password = $_POST['_password'];
        $password2 = $_POST['_password2'];
        $bDate = $_POST['_bDate'];

        if ($this->checkSignIn($entityManager, $name, $surname, $email, $phone, $password, $password2, $bDate) == '') {
            $user = new User();
            $user->setName($name);
            $user->setSurname($surname);
            $user->setEmail($email);
            $user->setPhoneNumber($phone);
            $user->setPassword($passwordHasher->hashPassword($user, $password));
            $user->setBirthDate(new \DateTime($bDate));
            // Asignar el rol de usuario 0 de la tabla role
            $role = $entityManager->getRepository(Role::class)->findOneBy(['idRole' => 0]);
            $user->setRole($role);
            $user->getRoles();
            $entityManager->persist($user);
            $entityManager->flush();

            $profile = new Profile();
            $profile->setUserName($username);
            $profile->setIdUser($user->getIdUser());
            $profile->setBio('Hello, I am new to ShadowGram!');
            $profile->setFollowers(0);
            $profile->setFollowing(0);
            $profile->setUser($user);
            $entityManager->persist($profile);
            $entityManager->flush();

            //Mandar correo de activación
            return $this->redirectToRoute('send_activation', ['email' => $email, 'name' => $name,]);
        }
        return $this->redirectToRoute('ctrl_login');
    }   
    
    #[Route('/activationSent', name:'send_activation')]
    public function sendActivation(EntityManagerInterface $entityManager, MailerInterface $mailer, Request $request){
        // Obtener el usuario a partir del email
        $email = $request->get('email');
        $name = $request->get('name');
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        $idUser = $user->getIdUser();

        // Insertar el token en la bbdd y su expiración con las entidades
        $token = bin2hex(random_bytes(32)); //Token de 64 caracteres
        $expiration = date("Y-m-d H:i:s", strtotime("+1 day")); //Fecha de expiración del token
        $expiration = new \DateTime($expiration);
        $accactivation = new Accactivation();
        $accactivation->setIdUser($idUser);
        $accactivation->setToken($token);
        $accactivation->setExpiration($expiration);
        $entityManager->persist($accactivation);
        $entityManager->flush();

        // Obtener el HTTP_HOST
        $host = $_SERVER['HTTP_HOST'];
        $baseURL= "$host/activation/$token";

        $message = (new Email())
        ->from(new Address('noreply_wizardmoneygang@shadowgram.com', 'Shadow Wizard Money Gang'))
        ->to($email)
        ->subject('Activate your account!')
        ->html("
            <body>
                <h2>¡Activa tu cuenta en ShadowGram</h2>
                <p>Hola , $name</p>
                <p>Gracias por registrarte en ShadowGram. Para comenzar a disfrutar de nuestra plataforma, activa tu cuenta haciendo clic en el siguiente botón:</p>
                <p>
                <a href='$baseURL' style='display: inline-block; padding: 12px 20px; font-size: 18px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;'>Activar mi cuenta</a>
                </p>
                <p>Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:</p>
                <p><a href='$baseURL'>$baseURL</a></p>
                <p style='font-size: 14px; color: #999;'>Si no has solicitado esta cuenta, ignora este mensaje.</p>
                <p style='font-size: 14px; color: #999;'>El equipo de ShadowGram</p>
            </body>
        ");

        $mailer->send($message);
        return $this->render('accManagment/activationEmail.html.twig');
    }

    #[Route('/activation/{token}', name:'activation')]
    public function activateAccount(EntityManagerInterface $entityManager, $token){
        // Comprobar que el token es correcto y que no ha expirado
        if (isset($token)){
            $accactivation = $entityManager->getRepository(Accactivation::class)->findOneBy(['token' => $token]);
            if ($accactivation){
                $expiration = $accactivation->getExpiration();
                $now = new \DateTime();
                if ($now < $expiration){
                    $idUser = $accactivation->getIdUser();
                    $user = $entityManager->getRepository(User::class)->findOneBy(['idUser' => $idUser]);
                    $role = $entityManager->getRepository(Role::class)->findOneBy(['idRole' => 1]);
                    $user->setRole($role);
                    $entityManager->persist($user);
                    $entityManager->remove($accactivation);
                    $entityManager->flush();
                    return $this->render('accManagment/activationSuccess.html.twig');
                }
            }
        }     
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
