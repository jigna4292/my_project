<?php

namespace App\Entity;

use App\Repository\ProviderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProviderRepository::class)
 */
class Provider
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
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\ManyToMany(targetEntity=Platform::class, inversedBy="providers")
     */
    private $Platform;

    /**
     * @ORM\OneToMany(targetEntity=Bundle::class, mappedBy="Provider")
     */
    private $bundles;

    public function __construct()
    {
        $this->Platform = new ArrayCollection();
        $this->bundles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection|Platform[]
     */
    public function getPlatform(): Collection
    {
        return $this->Platform;
    }

    public function addPlatform(Platform $platform): self
    {
        if (!$this->Platform->contains($platform)) {
            $this->Platform[] = $platform;
        }

        return $this;
    }

    public function removePlatform(Platform $platform): self
    {
        if ($this->Platform->contains($platform)) {
            $this->Platform->removeElement($platform);
        }

        return $this;
    }

    /**
     * @return Collection|Bundle[]
     */
    public function getBundles(): Collection
    {
        return $this->bundles;
    }

    public function addBundle(Bundle $bundle): self
    {
        if (!$this->bundles->contains($bundle)) {
            $this->bundles[] = $bundle;
            $bundle->setProvider($this);
        }

        return $this;
    }

    public function removeBundle(Bundle $bundle): self
    {
        if ($this->bundles->contains($bundle)) {
            $this->bundles->removeElement($bundle);
            // set the owning side to null (unless already changed)
            if ($bundle->getProvider() === $this) {
                $bundle->setProvider(null);
            }
        }

        return $this;
    }

    public function __tostring() {
     return $this->Name;
   }
}
