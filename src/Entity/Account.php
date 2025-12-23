<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 8)]
    private ?string $currency = null;

    #[ORM\Column]
    private ?float $starting_balance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $exclude_from_total_balance = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $createdBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getStartingBalance(): ?float
    {
        return $this->starting_balance;
    }

    public function setStartingBalance(float $starting_balance): static
    {
        $this->starting_balance = $starting_balance;

        return $this;
    }

    public function getExcludeFromTotalBalance(): ?string
    {
        return $this->exclude_from_total_balance;
    }

    public function setExcludeFromTotalBalance(?string $exclude_from_total_balance): static
    {
        $this->exclude_from_total_balance = $exclude_from_total_balance;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
