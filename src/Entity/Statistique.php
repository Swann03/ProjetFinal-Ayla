<?php

namespace App\Entity;

use App\Repository\StatistiqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatistiqueRepository::class)]
class Statistique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $killCount = null;

    #[ORM\Column]
    private ?int $deadCount = null;

    #[ORM\Column]
    private ?int $assistCount = null;

    #[ORM\ManyToOne(inversedBy: 'statistiques')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Rencontre $rencontre = null;   // ✅ renommé correctement

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKillCount(): ?int
    {
        return $this->killCount;
    }

    public function setKillCount(int $killCount): static
    {
        $this->killCount = $killCount;
        return $this;
    }

    public function getDeadCount(): ?int
    {
        return $this->deadCount;
    }

    public function setDeadCount(int $deadCount): static
    {
        $this->deadCount = $deadCount;
        return $this;
    }

    public function getAssistCount(): ?int
    {
        return $this->assistCount;
    }

    public function setAssistCount(int $assistCount): static
    {
        $this->assistCount = $assistCount;
        return $this;
    }

    public function getRencontre(): ?Rencontre
    {
        return $this->rencontre;
    }

    public function setRencontre(?Rencontre $rencontre): static
    {
        $this->rencontre = $rencontre;
        return $this;
    }
}

