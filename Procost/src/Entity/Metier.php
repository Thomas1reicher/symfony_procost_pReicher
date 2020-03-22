<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetierRepository")
 */
class Metier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\ManyToMany(targetEntity="App\Entity\Metier", inversedBy="versions")
     * @ORM\JoinColumn(name="metier_id" )
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $metier_titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMetierTitre(): ?string
    {
        return $this->metier_titre;
    }

    public function setMetierTitre(string $metier_titre): self
    {
        $this->metier_titre = $metier_titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
