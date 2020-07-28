<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WalletRepository::class)
 */
class Wallet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Clients::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_client;

    /**
     * @ORM\Column(type="float")
     */
    private $balance;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $confirmPay;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdClient(): ?Clients
    {
        return $this->id_client;
    }

    public function setIdClient(Clients $id_client): self
    {
        $this->id_client = $id_client;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getConfirmPay(): ?float
    {
        return $this->confirmPay;
    }

    public function setConfirmPay(?float $confirmPay): self
    {
        $this->confirmPay = $confirmPay;

        return $this;
    }
}
