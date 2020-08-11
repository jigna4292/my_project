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
    private $Name;

    /**
     * @ORM\ManyToMany(targetEntity=Provider::class, mappedBy="Platform")
     */
    private $providers;

    /**
     * @ORM\OneToMany(targetEntity=Bundle::class, mappedBy="Platform", orphanRemoval=true)
     */
    private $bundles;

    public function __construct()
    {
        $this->providers = new ArrayCollection();
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

    /**
     * @return Collection|Provider[]
     */
    public function getProviders(): Collection
    {
        return $this->providers;
    }

    public function addProvider(Provider $provider): self
    {
        if (!$this->providers->contains($provider)) {
            $this->providers[] = $provider;
            $provider->addPlatform($this);
        }

        return $this;
    }

    public function removeProvider(Provider $provider): self
    {
        if ($this->providers->contains($provider)) {
            $this->providers->removeElement($provider);
            $provider->removePlatform($this);
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
            $bundle->setPlatform($this);
        }

        return $this;
    }

    public function removeBundle(Bundle $bundle): self
    {
        if ($this->bundles->contains($bundle)) {
            $this->bundles->removeElement($bundle);
            // set the owning side to null (unless already changed)
            if ($bundle->getPlatform() === $this) {
                $bundle->setPlatform(null);
            }
        }

        return $this;
    }

    public function __tostring() {
     return $this->Name;
   }
}
