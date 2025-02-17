<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\DateTime;

#[ORM\Entity] 
#[ORM\Table(name: 'user')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type:'integer', name:'idUser')]
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
	
	#[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'idRole')]
	#[ORM\JoinColumn(name:'role', referencedColumnName:'idRole')]
	private $Role;
	
	#[ORM\OneToOne(targetEntity: Profile::class, mappedBy: 'User')]
	private $Profile;

	//-----------------------------------------------------------

	public function getIdUser() : ?int {
		return $this->idUser;
	}
	public function setIdUser(?int $idUser) {
		$this->idUser = $idUser;
	}

	public function getName() : ?string {
		return $this->name;
	}
	public function setName(?string $name) {
		$this->name = $name;
	}

	public function getSurname() : ?string {
		return $this->surname;
	}
	public function setSurname(?string $surname) {
		$this->surname = $surname;
	}

	public function getEmail() : ?string {
		return $this->email;
	}
	public function setEmail(?string $email) {
		$this->email = $email;
	}

	public function getPhoneNumber() : ?int {
		return $this->phoneNumber;
	}
	public function setPhoneNumber(?int $phoneNumber) {
		$this->phoneNumber = $phoneNumber;
	}

	public function getBirthDate() : \DateTime {
		return $this->birthDate;
	}
	public function setBirthDate(\DateTime $birthDate) {
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

	public function getRole() : ?Role {
		return $this->Role;
	}
	public function setRole(?Role $role) {
		$this->Role = $role;
	}

	public function getProfile() : ?Profile {
		return $this->Profile;
	}
	public function setProfile(?Profile $profile) {
		$this->Profile = $profile;
	}

//-----------------------------------------------------------

	// ----- No usar por seguridad
	// public function toArray(): array {
	// 	return [
	// 		'idUser' => $this->idUser,
	// 		'name' => $this->name,
	// 		'surname' => $this->surname,
	// 		'email' => $this->email,
	// 		'phoneNumber' => $this->phoneNumber,
	// 		'birthDate' => $this->birthDate,
	// 		'role' => $this->Role->toArray(),
	// 		'profile' => $this->Profile->toArray(false)
	// 	];
	// }

	public function getRoles(): array
	{
		// Switch para asignar roles
		switch ($this->Role->getIdRole()) {
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
