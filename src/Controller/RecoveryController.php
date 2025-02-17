<?php 

namespace App\Controller;

use App\Entity\User;
use App\Entity\Accactivation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class RecoveryController extends AbstractController
{
    #[Route('/recovery', name: 'load_recovery')]
    public function load_recovery(): Response
    {
        return $this->render('accManagment/recovery.html.twig');
    }

    #[Route('/recovery/send', name: 'reset_password')]
    public function reset_password(EntityManagerInterface $entityManager, Request $request, MailerInterface $mailer): Response
    {
        // Verificar que el correo existe en la base de datos
        $email = $request->request->get('_email');
        $name = $request->request->get('_name');
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($user == null) {
            return $this->render('accManagment/recovery.html.twig', ['error' => 'Email not found']);
        }

        // Generar un token aleatorio
        $token = bin2hex(random_bytes(32));
        $acctivation = new Accactivation();
        $acctivation->setUser($user);
        $acctivation->setToken($token);
        $acctivation->setExpiration(new \DateTime('+1 day'));
        $entityManager->persist($acctivation);
        $entityManager->flush();

        // Enviar un correo con el token
        // Obtener el HTTP_HOST
        $host = $_SERVER['HTTP_HOST'];
        $baseURL= "$host/recovery/reset/$token";

        $message = (new Email())
        ->from(new Address('noreply_wizardmoneygang@shadowgram.com', 'Shadow Wizard Money Gang'))
        ->to($email)
        ->subject('Recupera tu cuenta!')
        ->html("
            <body>
                <h2>¡Recupera tu cuenta en ShadowGram</h2>
                <p>Hola , $name</p>
                <p>Gracias por querer recuperar tu cuenta en ShadowGram. Para continuar disfrutando de nuestra plataforma, recupera tu cuenta haciendo clic en el siguiente botón:</p>
                <p>
                <a href='$baseURL' style='display: inline-block; padding: 12px 20px; font-size: 18px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;'>Recuperar mi cuenta</a>
                </p>
                <p>Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:</p>
                <p><a href='$baseURL'>$baseURL</a></p>
                <p style='font-size: 14px; color: #999;'>Si no has solicitado esta cuenta, ignora este mensaje.</p>
                <p style='font-size: 14px; color: #999;'>El equipo de ShadowGram</p>
            </body>
        ");
        $mailer->send($message);

        return $this->render('accManagment/recoverySend.html.twig');
    }

    #[Route('/recovery/reset/{token}', name: 'load_reset')]
    public function load_reset($token, EntityManagerInterface $entityManager): Response
    {
        $accactivation = $entityManager->getRepository(Accactivation::class)->findOneBy(['token' => $token]);
        if ($accactivation == null) {
            return $this->render('accManagment/recovery.html.twig', ['error' => 'Invalid token']);
        }
        return $this->render('accManagment/reset.html.twig', ['token' => $token]);
    }

    #[Route('/recovery/reset/{token}/complete', name: 'reset_password_post', methods: ['POST'])]
    public function reset_password_post($token, EntityManagerInterface $entityManager, Request $request): Response
    {   
        $email = $request->request->get('email');
        $pass1 = $request->request->get('password1');
        $pass2 = $request->request->get('password2');

        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        $accactivation = $entityManager->getRepository(Accactivation::class)->findOneBy(['token' => $token]);
        if ($accactivation == null) {
            return $this->redirectToRoute('reset_password');
        }

        if ($pass1 != $pass2) {
            var_dump($pass1);
            var_dump($pass2);
            // return $this->redirectToRoute('reset_password');
        } else {
            $user->setPassword(password_hash($pass1, PASSWORD_DEFAULT));
            $entityManager->persist($user);
            $entityManager->remove($accactivation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ctrl_login');
    }
}
