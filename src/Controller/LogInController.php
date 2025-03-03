<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LogInController extends AbstractController
{
    #[Route('/login', name:'ctrl_login')]
    public function login(){    
        return $this->render('accManagment/login.html.twig');
    }    

    #[Route('/logout', name:'ctrl_logout')]
    public function logout(){    
        return new Response();
    }    
}
