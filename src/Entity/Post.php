<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'post')]

class Post
{
	#[ORM\id]
    #[ORM\Column(type:'integer', name:'idPost')]
    #[ORM\GeneratedValue]
    private $idPost;
	
	#[ORM\Column(type:'integer', name:'idPoster')]
	#[ManyToOne(targetEntity: User::class, inversedBy: 'idUser')]
    #[JoinColumn(name: 'idUser', referencedColumnName: 'idUser')]
    private $name;

	#[ORM\Column(type:'string', name:'surname')]
    private $surname;

	#[ORM\Column(type:'string', name:'email')]
    private $email;

	#[ORM\Column(type:'integer', name:'phoneNumber')]
    private $phoneNumber;

	#[ORM\Column(type:'string', name:'password')]
    private $password;

	#[ORM\Column(type:'date', name:'birthDate')]
    private $birthDate;

//-----------------------------------------------------------

	public function getIdUser() {
		return $this->idUser;
	}
	public function getName() {
		return $this->name;
	}
	public function getSurname() {
		return $this->surname;
	}
	public function getEmail() {
		return $this->email;
	}
	public function getPhoneNumber() {
		return $this->phoneNumber;
	}
	public function getPassword() {
		return $this->password;
	}
	public function getBirthDate() {
		return $this->birthDate;
	}

	public function setIdUser() {
		$this->idUser = $idUser;
	}
	public function setName() {
		$this->name = $name;
	}
	public function setSurname() {
		$this->surname = $surname;
	}
	public function setEmail() {
		$this->email = $email;
	}
	public function setPhoneNumber() {
		$this->phoneNumber = $phoneNumber;
	}
	public function setPassword() {
		$this->password = $password;
	}
	public function setBirthDate() {
		$this->birthDate = $birthDate;
	}
}