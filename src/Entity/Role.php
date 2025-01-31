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

	public function getIdRole() {
		return $this->idRole;
	}

	public function getName() {
		return $this->name;
	}

	public function setIdRole($idRole) {
		$this->idRole = $idRole;
	}

	public function setName($name) {
		$this->name = $name;
	}
}
