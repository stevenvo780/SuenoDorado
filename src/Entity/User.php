<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $nombres;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $apellidos;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $telmovil;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $ciudad;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $pais;


    /**
     * @ORM\Column(type="date")
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     */
    private $plainPassword;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): self
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }


    public function getTelmovil(): ?string
    {
        return $this->telmovil;
    }

    public function setTelmovil(string $telmovil): self
    {
        $this->telmovil = $telmovil;

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

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(string $pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getFechaCreacion(): ?DateTime
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(DateTime $fechaCreacion): self
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->nombres;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
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
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
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
