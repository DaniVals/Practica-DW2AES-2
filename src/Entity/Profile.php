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

	#[ORM\OneToOne(targetEntity: User::class, mappedBy: 'idUser')]
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
	public function setUserName($userName) {
		$this->userName = $userName;
	}

	public function getIdUser() {
		return $this->idUser;
	}
	public function setIdUser($idUser) {
		$this->idUser = $idUser;
	}

	public function getBio() {
		return $this->bio;
	}
	public function setBio($bio) {
		$this->bio = $bio;
	}

	public function getFollowers() {
		return $this->followers;
	}
	public function setFollowers($followers) {
		$this->followers = $followers;
	}

	public function getFollowing() {
		return $this->following;
	}
	public function setFollowing($following) {
		$this->following = $following;
	}
}