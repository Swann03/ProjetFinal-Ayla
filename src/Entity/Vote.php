<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $point = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    private ?Equipe $vote = null;

    #[ORM\ManyToOne(inversedBy: 'rencontreVote')]
    private ?Rencontre $rencontre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(?int $point): static
    {
        $this->point = $point;

        return $this;
    }

    public function getVote(): ?Equipe
    {
        return $this->vote;
    }

    public function setVote(?Equipe $vote): static
    {
        $this->vote = $vote;

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
