<?php

namespace App\Entity;

use App\Repository\TokensRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TokensRepository::class)
 */
class Tokens
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Clients::class, inversedBy="Token_id", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Client_id;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $Secret_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientId(): ?Clients
    {
        return $this->Client_id;
    }

    public function setClientId(Clients $Client_id): self
    {
        $this->Client_id = $Client_id;

        return $this;
    }

    public function getSecretId(): ?string
    {
        return $this->Secret_id;
    }

    public function setSecretId(?string $Secret_id): self
    {
        $this->Secret_id = $Secret_id;

        return $this;
    }
}
