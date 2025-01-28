<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity] 
#[ORM\Table(name: 'user')]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	#[ORM\id]
    #[ORM\Column(type:'integer', name:'idUser')]
	#[OneToOne(targetEntity: Profile::class, mappedBy: 'idUser')]
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

//-----------------------------------------------------------

    private ?int $idUser = null;

    private ?string $email = null;

    private ?string $password = null; // Hashed password

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

	public function getRoles(): array
    {
		return ['ROLE_USER'];            
	}

    public function getUserIdentifier(): string
    {
        return $this->getMail();
    }

    public function getSalt(): ?string
    {
        return null;
    }
	
    public function eraseCredentials(): void
    {

    }

    // Otros métodos necesarios como getUsername(), getRoles(), eraseCredentials(), etc.
}
