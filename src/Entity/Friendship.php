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

	#[ORM\Column(type:'integer', name:'idRequestor')]
	private $idRequestor;

	#[ORM\Column(type:'integer', name:'idRequested')]
	private $idRequested;
	
	#[ORM\Column(type:'integer', name:'frState')]
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

	public function getIdRequestor() : ?int {
		return $this->idRequestor;
	}
	public function setIdRequestor(?int $idRequestor) {
		$this->idRequestor = $idRequestor;
	}

	public function getIdRequested() : ?int {
		return $this->idRequested;
	}
	public function setIdRequested(?int $idRequested) {
		$this->idRequested = $idRequested;
	}

	public function getFrState() : ?int {
		return $this->frState;
	}
	public function setFrState(?int $frState) {
		$this->frState = $frState;
	}

	public function getFrDate() : ?DateTime {
		return $this->frDate;
	}
	public function setFrDate(?DateTime $frDate) {
		$this->frDate = $frDate;
	}
}