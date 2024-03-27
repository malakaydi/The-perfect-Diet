<?php

namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatRepository::class)]
class Plat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomplat = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $cout = null;

    #[ORM\Column]
    private ?int $nbreCalories = null;

    #[ORM\Column(length: 255)]
    private ?string $ingredients = null;

    #[ORM\ManyToOne(inversedBy: 'plats')]
    private ?Regime $regime = null;

    #[ORM\ManyToOne(targetEntity: Image::class)]
private ?Image $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomplat(): ?string
    {
        return $this->nomplat;
    }

    public function setNomplat(string $nomplat): static
    {
        $this->nomplat = $nomplat;

        return $this;
    }

    public function getCout(): ?string
    {
        return $this->cout;
    }

    public function setCout(string $cout): static
    {
        $this->cout = $cout;

        return $this;
    }

    public function getNbreCalories(): ?int
    {
        return $this->nbreCalories;
    }

    public function setNbreCalories(int $nbreCalories): static
    {
        $this->nbreCalories = $nbreCalories;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): static
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getRegime(): ?Regime
    {
        return $this->regime;
    }

    public function setRegime(?Regime $regime): static
    {
        $this->regime = $regime;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }
    
    public function setImage(?Image $image): static
    {
        $this->image = $image;
    
        return $this;
    }

    
}
