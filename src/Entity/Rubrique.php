<?php

// src/Entity/Rubrique.php

namespace App\Entity;

use App\Repository\RubriqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RubriqueRepository::class)]
class Rubrique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'rubrique', targetEntity: SousRubrique::class, cascade: ['persist', 'remove'])]
    private $sousRubriques;

    public function __construct()
    {
        $this->sousRubriques = new ArrayCollection();
    }

    // getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|SousRubrique[]
     */
    public function getSousRubriques(): Collection
    {
        return $this->sousRubriques;
    }

    public function addSousRubrique(SousRubrique $sousRubrique): self
    {
        if (!$this->sousRubriques->contains($sousRubrique)) {
            $this->sousRubriques[] = $sousRubrique;
            $sousRubrique->setRubrique($this);
        }

        return $this;
    }

    public function removeSousRubrique(SousRubrique $sousRubrique): self
    {
        if ($this->sousRubriques->removeElement($sousRubrique)) {
            // set the owning side to null (unless already changed)
            if ($sousRubrique->getRubrique() === $this) {
                $sousRubrique->setRubrique(null);
            }
        }

        return $this;
    }
}
