<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

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
     * 
     * @ORM\Column(type="string", length=55, unique=true)
     */
    private $Documento;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $Nombres;

    /**
     * @ORM\Column(type="string", length=55, unique=true)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $Celular;

    /**
     * @ORM\OneToOne(targetEntity=Tokens::class, mappedBy="Client_id", cascade={"persist", "remove"})
     */
    private $Token_id;

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

    public function getTokenId(): ?Tokens
    {
        return $this->Token_id;
    }

    public function setTokenId(Tokens $Token_id): self
    {
        $this->Token_id = $Token_id;

        // set the owning side of the relation if necessary
        if ($Token_id->getClientId() !== $this) {
            $Token_id->setClientId($this);
        }

        return $this;
    }
}
