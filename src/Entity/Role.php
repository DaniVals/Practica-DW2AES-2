<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'role')]

class Role
{
	#[ORM\Id]
	#[ORM\Column(type:'integer', name:'idRole')]
	private $idRole;

	#[ORM\Column(type:'string', name:'name')]
	private $name;

//-----------------------------------------------------------

	public function getIdRole() : ?int {
		return $this->idRole;
	}
	public function setIdRole(?int $idRole) {
		$this->idRole = $idRole;
	}

	public function getName() : ?string {
		return $this->name;
	}
	public function setName(?string $name) {
		$this->name = $name;
	}

	public function toArray() {
		return [
			'idRole' => $this->idRole,
			'name' => $this->name
		];
	}
}
