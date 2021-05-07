<?php

namespace App\Security;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
	private $id;
	private $email;
	private $password;
	private $token;
	private $roles = [];
	private $cart = [];


	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(int $id): self
	{
		$this->id = $id;

		return $this;
	}
	public function getCart(): ?array
	{
		return $this->cart;
	}

	public function setCart(array $cart): self
	{
		$this->cart = $cart;

		return $this;
	}
	public function getToken(): ?string
	{
		return $this->token;
	}

	public function setToken(string $token): self
	{
		$this->token = $token;

		return $this;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 */
	public function getUsername(): string
	{
		return (string) $this->email;
	}

	/**
	 * @see UserInterface
	 */
	public function getRoles(): array
	{
		$roles = $this->roles;
		// guarantee every user at least has ROLE_USER

		return array_unique($roles);
	}

	public function setRoles(array $roles): self
	{
		$this->roles = $roles;

		return $this;
	}

	public function hasRole(string $role): bool
	{
		if (in_array($role, $this->roles)) {
			return true;
		}

		return false;
	}

	public function removeRole(string $role)
	{
		if ($this->hasRole($role)) {
			unset($this->roles[array_search($role, $this->roles)]);
		}

		$this->roles = array_values($this->roles);
	}

	public function removeAllRoles()
	{
		$this->roles = [];
	}

	/**
	 * @see UserInterface
	 */
	public function getPassword(): string
	{
		return (string) $this->password;
	}

	public function setPassword(string $password): self
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Returning a salt is only needed, if you are not using a modern
	 * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
	 *
	 * @see UserInterface
	 */
	public function getSalt(): ?string
	{
		return null;
	}

	/**
	 * @see UserInterface
	 */
	public function eraseCredentials()
	{
		// If you store any temporary, sensitive data on the user, clear it here
		// $this->plainPassword = null;
	}

}
