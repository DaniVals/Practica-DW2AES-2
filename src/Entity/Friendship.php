<?php

namespace App\Entity;
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


}