<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categoria;
use App\Entity\Producto;
use App\Entity\Pedido;
use App\Entity\PedidoProducto;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TestingDELETE extends AbstractController
{
	#[Route('/feed', name:'feed')]
    public function loadFeed() {

		return $this->render("navigation/feed.html.twig");
    }
	#[Route('/iniciasesion', name:'inicio_sesion')]
    public function loadIS() {

		return $this->render("singin.html.twig");
    }
	#[Route('/profile', name:'profile')]
    public function loadProfile() {

		$usuario["idUser"] = "0";
		$usuario["userName"] = "nombre";
		$usuario["bio"] = "una biografia muy bonita";
		$usuario["followers"] = "777";
		$usuario["following"] = "69";
		return $this->render("navigation/profile.html.twig" , [ "targetUser" => $usuario ]);
    }
	#[Route('/posts', name:'posts')]
    public function loadPosts() {
		$posts = array();

		$usuario["idUser"] = "0";
		$usuario["userName"] = "nombre";
		$usuario["bio"] = "una biografia muy bonita";
		$usuario["followers"] = "777";
		$usuario["following"] = "69";

		$post["idPost"] = "0";
		$post["idPoster"] = $usuario;
		$post["likes"] = "3";
		$post["postingTime"] = "0";
		$post["commentAmount"] = "about";
		$post["contentRoute"] = "";

		array_push($posts, $post);

		// devolver un new Response con un json para AJAX
		return new Response(json_encode($posts));
    }
}