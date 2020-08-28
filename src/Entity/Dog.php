<?php

namespace App\Entity;

use App\Repository\DogRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 
 *  @ApiResource(
 *      normalizationContext={"groups"={"dog:read"}},
 *      denormalizationContext={"groups"={"dog:write"}},
 *      collectionOperations={
 *         "get",
 *         "post"={"security"="is_granted('ROLE_USER')"}
 *     },
 *       itemOperations={
 *         "get",
 *         "put"={"security"="is_granted('edit', object)"},
 *         "delete"={"security"="is_granted('delete', object)"}
 *     },
 * )
 * @ORM\Entity(repositoryClass=DogRepository::class)
 */
class Dog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * 
     * @Groups({"dog:read", "user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *      pattern="[a-zA-Z0-9]"
     * )
     * 
     * 
     * @Groups({"dog:read","dog:write","user:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *      pattern="[A-Z]"
     * )
     * 
     * 
     * @Groups({"dog:read","dog:write"})
     *
     */
    private $sexe;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"dog:read","dog:write"})
     */
    private $castre;

    /**
     * @ORM\Column(type="date")
     * @Groups({"dog:read","dog:write"})
     * 
     */
    private $birthday_at;

    

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\Regex(
     *      pattern="[A-Z]"
     * )
     * 
     * @Groups({"dog:read","dog:write"})
     */
    private $taille;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"dog:read","dog:write"})
     */
    private $profilePic;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * @Groups({"dog:read","dog:write"})
     */
    private $laisse;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * @Groups({"dog:read","dog:write"})
     */
    private $museliere;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * @Groups({"dog:read","dog:write"})
     */
    private $randonnee;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * @Groups({"dog:read","dog:write"})
     */
    private $baballe;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * @Groups({"dog:read","dog:write"})
     */
    private $baton;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * @Groups({"dog:read","dog:write"})
     */
    private $frisbee;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * @Groups({"dog:read","dog:write"})
     */
    private $velo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * @Groups({"dog:read","dog:write"})
     */
    private $nage;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * @Groups({"dog:read","dog:write"})
     */
    private $neige;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Groups({"dog:read","dog:write"})
     */
    private $ecoleDressage;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * @Groups({"dog:read","dog:write"})
     */
    private $agility;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="dogs")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups("dog:read")
     */
    private $user;

    

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"dog:read","dog:write"})
     */
    private $picture1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"dog:read","dog:write"})
     */
    private $picture2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"dog:read","dog:write"})
     */
    private $picture3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"dog:read","dog:write"})
     */
    private $picture4;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups("dog:read")
     */
    private $slug;

    public function __construct()
    {
        
        $this->laisse=false;
        $this->museliere=false;
        $this->randonnee=false;
        $this->baballe=false;
        $this->baton=false;
        $this->frisbee=false;
        $this->velo=false;
        $this->nage=false;
        $this->neige=false;
        $this->agility=false;
        
    }
    

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getCastre(): ?bool
    {
        return $this->castre;
    }

    public function setCastre(bool $castre): self
    {
        $this->castre = $castre;

        return $this;
    }

    public function getBirthdayAt(): ?\DateTimeInterface
    {
        return $this->birthday_at;
    }

    public function setBirthdayAt(\DateTimeInterface $birthday_at): self
    {
        $this->birthday_at = $birthday_at;

        return $this;
    }

    
    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getLaisse(): ?bool
    {
        return $this->laisse;
    }

    public function setLaisse(?bool $laisse): self
    {
        $this->laisse = $laisse;

        return $this;
    }

    public function getMuseliere(): ?bool
    {
        return $this->museliere;
    }

    public function setMuseliere(?bool $museliere): self
    {
        $this->museliere = $museliere;

        return $this;
    }

    public function getRandonnee(): ?bool
    {
        return $this->randonnee;
    }

    public function setRandonnee(?bool $randonnee): self
    {
        $this->randonnee = $randonnee;

        return $this;
    }

    public function getBaballe(): ?bool
    {
        return $this->baballe;
    }

    public function setBaballe(?bool $baballe): self
    {
        $this->baballe = $baballe;

        return $this;
    }

    public function getBaton(): ?bool
    {
        return $this->baton;
    }

    public function setBaton(?bool $baton): self
    {
        $this->baton = $baton;

        return $this;
    }

    public function getFrisbee(): ?bool
    {
        return $this->frisbee;
    }

    public function setFrisbee(?bool $frisbee): self
    {
        $this->frisbee = $frisbee;

        return $this;
    }

    public function getVelo(): ?bool
    {
        return $this->velo;
    }

    public function setVelo(?bool $velo): self
    {
        $this->velo = $velo;

        return $this;
    }

    public function getNage(): ?bool
    {
        return $this->nage;
    }

    public function setNage(?bool $nage): self
    {
        $this->nage = $nage;

        return $this;
    }

    public function getNeige(): ?bool
    {
        return $this->neige;
    }

    public function setNeige(?bool $neige): self
    {
        $this->neige = $neige;

        return $this;
    }

    public function getEcoleDressage(): ?string
    {
        return $this->ecoleDressage;
    }

    public function setEcoleDressage(?string $ecoleDressage): self
    {
        $this->ecoleDressage = $ecoleDressage;

        return $this;
    }

    public function getAgility(): ?bool
    {
        return $this->agility;
    }

    public function setAgility(?bool $agility): self
    {
        $this->agility = $agility;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProfilePic(): ?string
    {
        return $this->profilePic;
    }

    public function setProfilePic(string $profilePic): self
    {
        $this->profilePic = $profilePic;

        return $this;
    }

    public function getPicture1(): ?string
    {
        return $this->picture1;
    }

    public function setPicture1(?string $picture1): self
    {
        $this->picture1 = $picture1;

        return $this;
    }

    public function getPicture2(): ?string
    {
        return $this->picture2;
    }

    public function setPicture2(?string $picture2): self
    {
        $this->picture2 = $picture2;

        return $this;
    }

    public function getPicture3(): ?string
    {
        return $this->picture3;
    }

    public function setPicture3(?string $picture3): self
    {
        $this->picture3 = $picture3;

        return $this;
    }

    public function getPicture4(): ?string
    {
        return $this->picture4;
    }

    public function setPicture4(?string $picture4): self
    {
        $this->picture4 = $picture4;

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
