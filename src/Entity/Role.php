<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'role')]

class Role
{
	#[ORM\id]
    #[ORM\Column(type:'integer', name:'idRole')]
    private $idRole;

	#[ORM\Column(type:'string', name:'name')]
    private $name;
}