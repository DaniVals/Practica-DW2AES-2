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
	
	#[ORM\Column(type:'string', name:'bio')]
    private $bio;
	
	#[ORM\Column(type:'integer', name:'followers')]
    private $followers;
	
	#[ORM\Column(type:'integer', name:'following')]
    private $following;

	#[ORM\OneToOne(targetEntity: User::class, inversedBy: 'Profile')]
	#[ORM\JoinColumn(name: 'idProfile', referencedColumnName: 'idUser')]
	private $User;
	
	// #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'idPoster')]
	// private $posts;

//-----------------------------------------------------------

	public function getUserName() : ?string {
		return $this->userName;
	}
	public function setUserName(?string $userName) {
		$this->userName = $userName;
	}

	public function getBio() : ?string {
		return $this->bio;
	}
	public function setBio(?string $bio) {
		$this->bio = $bio;
	}

	public function getFollowers() : ?int {
		return $this->followers;
	}
	public function setFollowers(?int $followers) {
		$this->followers = $followers;
	}

	public function getFollowing() : ?int {
		return $this->following;
	}
	public function setFollowing(?int $following) {
		$this->following = $following;
	}

	public function getUser() : ?User {
		return $this->User;
	}
	public function setUser(?User $User) {
		$this->idUser = $User;
	}

//-----------------------------------------------------------

	public function toArray(?bool $fullProfile = true): array {
		if ($fullProfile) {
			return [
				"userName" => $this->userName,
				"User" => $this->User->toArray(),
				"bio" => $this->bio,
				"followers" => $this->followers,
				"following" => $this->following
			];
		}
		return [
			"userName" => $this->userName,
			"idProfile" => $this->User->getIdUser(),
			"bio" => $this->bio,
			"followers" => $this->followers,
			"following" => $this->following
		];
	}
}