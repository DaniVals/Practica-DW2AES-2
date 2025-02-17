<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutUsController extends AbstractController
{
    #[Route('/about_us', name: 'about_us')]
    public function about_us(): Response
    {
        return $this->render('navigation/about_us.html.twig');
    }
}
