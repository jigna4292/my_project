<?php

namespace App\Entity;

use App\Repository\BundleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BundleRepository::class)
 */
class Bundle
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
     * @ORM\Column(type="float")
     */
    private $Price;

    /**
     * @ORM\ManyToOne(targetEntity=Provider::class, inversedBy="bundles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Provider;

    /**
     * @ORM\ManyToOne(targetEntity=Platform::class, inversedBy="bundles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Platform;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Image;

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

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getProvider(): ?Provider
    {
        return $this->Provider;
    }

    public function setProvider(?Provider $Provider): self
    {
        $this->Provider = $Provider;

        return $this;
    }

    public function getPlatform(): ?Platform
    {
        return $this->Platform;
    }

    public function setPlatform(?Platform $Platform): self
    {
        $this->Platform = $Platform;

        return $this;
    }
    
    public function __tostring() {
        return $this->Name;
    }

    public function getImage(): ?string
    {        
        if( isset( $_GET['action'] ) ) {

           if( $_GET['action'] == 'list' ) {
             if (strpos($this->Image, '\\') !== false) {
               $image_arr = explode('\\', $this->Image);
               return end($image_arr);
             } else {
               return $this->Image;
             }
           } else {
               return $this->Image;  
           }

         } else {
            if (strpos($this->Image, '\\') !== false) {
               $image_arr = explode('\\', $this->Image);
               return end($image_arr);
             } else {
               return $this->Image;
             }
         }
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }
}