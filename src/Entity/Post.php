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
	public function setIdUser($idUser) {
		$this->idUser = $idUser;
	}

	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}

	public function getSurname() {
		return $this->surname;
	}
	public function setSurname($surname) {
		$this->surname = $surname;
	}

	public function getEmail() {
		return $this->email;
	}
	public function setEmail($email) {
		$this->email = $email;
	}

	public function getPhoneNumber() {
		return $this->phoneNumber;
	}
	public function setPhoneNumber($phoneNumber) {
		$this->phoneNumber = $phoneNumber;
	}

	public function getPassword() {
		return $this->password;
	}
	public function setPassword($password) {
		$this->password = $password;
	}

	public function getBirthDate() {
		return $this->birthDate;
	}
	public function setBirthDate($birthDate) {
		$this->birthDate = $birthDate;
	}
}