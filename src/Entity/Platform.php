<?php

namespace App\Entity;

use App\Repository\PlatformRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlatformRepository::class)
 */
class Platform
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Software::class, mappedBy="platform")
     */
    private $platform;

    public function __construct()
    {
        $this->platform = new ArrayCollection();
    }

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
     * @return Collection|Software[]
     */
    public function getPlatform(): Collection
    {
        return $this->platform;
    }

    public function addPlatform(Software $platform): self
    {
        if (!$this->platform->contains($platform)) {
            $this->platform[] = $platform;
            $platform->setPlatform($this);
        }

        return $this;
    }

    public function removePlatform(Software $platform): self
    {
        if ($this->platform->contains($platform)) {
            $this->platform->removeElement($platform);
            // set the owning side to null (unless already changed)
            if ($platform->getPlatform() === $this) {
                $platform->setPlatform(null);
            }
        }

        return $this;
    }

    public function __toString() {
         return $this->name;
    }
}
