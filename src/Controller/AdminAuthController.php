<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class AdminAuthController extends AbstractController {
    #[Route('/admin', name:'admin')]
    public function admin() {   
        return $this->render('admin.html.twig');
    }
    #[Route('/admin/users', name:'admin_users')]
    public function users() {   
        return $this->render('admin_users.html.twig');
    }
}
