<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'friendship')]

class Friendship
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type:'integer', name:'idFriendship')]
	private $idFriendship;

	#[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'idRequestor', referencedColumnName: 'idUser')]
	private $IdRequestor;

	#[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'idRequested', referencedColumnName: 'idUser')]
	private $IdRequested;
	
	#[ORM\ManyToOne(targetEntity: State::class, inversedBy: 'idState')]
	#[ORM\JoinColumn(name:'frState', referencedColumnName:'idState')]
	private $frState;
	
	#[ORM\Column(type:'datetime', name:'frDate')]
	private $frDate;

//-----------------------------------------------------------

	public function getIdFriendship() : ?int {
		return $this->idFriendship;
	}
	public function setIdFriendship(?int $idFriendship) {
		$this->idFriendship = $idFriendship;
	}

	public function getIdRequestor() : ?User {
		return $this->IdRequestor;
	}
	public function setIdRequestor(?User $IdRequestor) {
		$this->IdRequestor = $IdRequestor;
	}

	public function getIdRequested() : ?User {
		return $this->IdRequested;
	}
	public function setIdRequested(?User $IdRequested) {
		$this->IdRequested = $IdRequested;
	}

	public function getFrState() : ?State {
		return $this->frState;
	}
	public function setFrState(?State $frState) {
		$this->frState = $frState;
	}

	public function getFrDate() : ?DateTime {
		return $this->frDate;
	}
	public function setFrDate(?DateTime $frDate) {
		$this->frDate = $frDate;
	}
}