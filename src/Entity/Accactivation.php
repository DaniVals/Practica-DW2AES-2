<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

#[ORM\Entity] 
#[ORM\Table(name: 'accactivation')]

class Accactivation
{
	#[ORM\Id]
	#[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'idUser')]
    private $idUser;

	#[ORM\Column(type:'string', name:'token')]
	private $token;

	#[ORM\Column(type:'datetime', name:'expiration')]
	private $expiration;

//-----------------------------------------------------------

	public function getUser() : ?User {
		return $this->idUser;
	}
	public function setUser(?User $IdUser) {
		$this->idUser = $IdUser;
	}

	public function getToken() : ?string {
		return $this->token;
	}
	public function setToken(?string $token) {
		$this->token = $token;
	}

	public function getExpiration() : \DateTime {
		return $this->expiration;
	}
	public function setExpiration(\DateTime $expiration) {
		$this->expiration = $expiration;
	}
}
