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

	#[ORM\ManyToOne(targetEntity:'Role')]
	#[ORM\JoinColumn(name:'role', referencedColumnName:'idRole')]
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

	public function getRole() {
		return $this->role;
	}

	public function setRole(?Role $role) {
		$this->role = $role;
	}

	public function getRoles(): array
	{
		// Switch para asignar roles
		switch ($this->role->getIdRole()) {
			case 0:
				return ['ROLE_NOTV'];
				break;
			case 1:
				return ['ROLE_USER'];
				break;
			case 2:
				return ['ROLE_USER', 'ROLE_ADMIN'];
				break;
			default:
				// No se que poner en el caso default, lo dejo vacío
				return [];
				break;
		}
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
