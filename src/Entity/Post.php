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
    #[JoinColumn(name: 'idPoster', referencedColumnName: 'idUser')]
    private $idPoster;

	#[ORM\Column(type:'integer', name:'likes')]
    private $likes;

	#[ORM\Column(type:'integer', name:'dislikes')]
    private $dislikes;

	#[ORM\Column(type:'Types::DATETIME_IMMUTABLE', name:'postingTime')]
    private $postingTime;

	#[ORM\Column(type:'integer', name:'commentAmount')]
    private $commentAmount;

	#[ORM\Column(type:'string', name:'contentRoute')]
    private $contentRoute;

//-----------------------------------------------------------

	public function getIdPoster() {
		return $this->idPoster;
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