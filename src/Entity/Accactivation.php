<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'accactivation')]

class Accactivation
{
	#[ORM\Id]
    #[ORM\Column(type:'integer', name:'idUser')]
    private $idUser;

	#[ORM\Column(type:'string', name:'token')]
	private $token;

	#[ORM\Column(type:'datetime', name:'expiration')]
	private $expiration;

//-----------------------------------------------------------

	public function getIdUser() {
		return $this->idUser;
	}
	public function setIdUser($idUser) {
		$this->idUser = $idUser;
	}

	public function getToken() {
		return $this->token;
	}
	public function setToken($token) {
		$this->token = $token;
	}

	public function getExpiration() {
		return $this->expiration;
	}
	public function setExpiration($expiration) {
		$this->expiration = $expiration;
	}
}
