<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientsRepository::class)
 */
class Clients
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $Documento;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $Nombres;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $Celular;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocumento(): ?string
    {
        return $this->Documento;
    }

    public function setDocumento(string $Documento): self
    {
        $this->Documento = $Documento;

        return $this;
    }

    public function getNombres(): ?string
    {
        return $this->Nombres;
    }

    public function setNombres(string $Nombres): self
    {
        $this->Nombres = $Nombres;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getCelular(): ?string
    {
        return $this->Celular;
    }

    public function setCelular(string $Celular): self
    {
        $this->Celular = $Celular;

        return $this;
    }
}
