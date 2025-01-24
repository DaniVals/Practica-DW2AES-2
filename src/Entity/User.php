<?php
namespace App\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private ?int $id = null;

    private ?string $email = null;

    
    // TODO: Hacer más setter y getter
    // TODO: Hcaer las relaciones con la bbdd


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
