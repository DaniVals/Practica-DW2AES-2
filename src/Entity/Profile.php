<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'profile')]

class Profile
{
	#[ORM\Id]
    #[ORM\Column(type:'string', name:'userName')]
    private $userName;

	#[ORM\Column(type:'integer', name:'idUser')]
	#[OneToOne(targetEntity: User::class, inversedBy: 'idUser')]
    #[JoinColumn(name: 'idUser', referencedColumnName: 'idUser')]
	private $idUser;

	#[ORM\Column(type:'string', name:'bio')]
    private $bio;

	#[ORM\Column(type:'integer', name:'followers')]
    private $followers;

	#[ORM\Column(type:'integer', name:'following')]
    private $following;

//-----------------------------------------------------------

	public function getUserName() {
		return $this->userName;
	}
	public function getIdUser() {
		return $this->idUser;
	}
	public function getBio() {
		return $this->bio;
	}
	public function getFollowers() {
		return $this->followers;
	}
	public function getFollowing() {
		return $this->following;
	}

	public function setUserName() {
		$this->userName = $userName;
	}
	public function setIdUser() {
		$this->idUser = $idUser;
	}
	public function setBio() {
		$this->bio = $bio;
	}
	public function setFollowers() {
		$this->followers = $followers;
	}
	public function setFollowing() {
		$this->following = $following;
	}
}