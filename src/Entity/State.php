<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'state')]

class State
{
	#[ORM\Id]
	#[ORM\Column(type:'integer', name:'idState')]
	private $idState;

	#[ORM\Column(type:'string', name:'name')]
	private $name;

//-----------------------------------------------------------

	public function getIdState() : ?int {
		return $this->idState;
	}
	public function setIdState(?int $idState) {
		$this->idState = $idState;
	}

	public function getName() : ?string {
		return $this->name;
	}
	public function setName(?string $name) {
		$this->name = $name;
	}

	public function toArray() {
		return [
			'idState' => $this->idState,
			'name' => $this->name
		];
	}
}