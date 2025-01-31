<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity] 
#[ORM\Table(name: 'user')]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	#[ORM\Id]
	#[ORM\Column(type:'integer', name:'idUser')]
	#[ORM\OneToOne(targetEntity: Profile::class, mappedBy: 'idUser')]
	#[ORM\GeneratedValue]
	private $idUser;

	#[ORM\Column(type:'string', name:'name')]
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

	#[ORM\ManyToOne(targetEntity:'role')]
	#[ORM\JoinColumn(name:'role', referencedColumn:'idRole')]
	private $role;

	//-----------------------------------------------------------

	public function getIdUser() {
		return $this->idUser;
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

	public function getBirthDate() {
		return $this->birthDate;
	}
	public function setBirthDate($birthDate) {
		$this->birthDate = $birthDate;
	}

	public function getPassword(): ?string
	{
		return $this->password;
	}
	public function setPassword(string $password): self
	{
		$this->password = $password;

		return $this;
	}

	public function getRole(): array
	{
		return ['ROLE_USER'];            
	}

	public function getUserIdentifier(): string
	{
		return $this->getEmail();
	}

	public function getSalt(): ?string
	{
		return null;
	}

	public function eraseCredentials(): void
	{

	}
}
