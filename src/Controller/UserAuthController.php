<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class UserAuthController extends AbstractController {
    #[Route('/', name:'root')]
    public function feed() {   
        return $this->redirectToRoute('load_feed');
    }
    #[Route('/feed', name:'load_feed')]
    public function load_feed() {   
        return $this->render('feed.html.twig');
    }
    
}
