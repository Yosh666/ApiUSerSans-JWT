<?php
// C:\Users\Stagiaire\Desktop\PFA\ApiUser>git reset --hard 98008b2
// HEAD is now at 98008b2 jwt token et authentification à faire
/*NOTE
j'hésite à tester avec une apiKey autogénéré à chaque inscription*/
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\SerializedName;
/*NOTE
regex pr les htmlspecial char
[^!@#$%^&*(),;.?":{}|<>]
*/


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * 
 * @UniqueEntity(fields={"email"})
 * @UniqueEntity(fields={"username"})
 * 
 * @ApiResource(
 *      normalizationContext={"groups"={"user:read"}},
 *      denormalizationContext={"groups"={"user:write"}}
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user:read","dog:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * 
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     *  @Groups({"user:read", "user:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * 
     *
     */
    private $password;

    /**
     * @Groups({"user:write"})
     * 
     * @SerializedName("password")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * 
     * @Groups({"user:read", "user:write","dog:read"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"user:read", "user:write"})
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Groups({"user:read", "user:write"})
     */
    private $departementCode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups({"user:read", "user:write"})
     */
    private $circleRange;

    /**
     * @ORM\OneToMany(targetEntity=Dog::class, mappedBy="user", orphanRemoval=true)
     * 
     * @Groups({"user:read"})
     */
    private $dogs;

    /**
     * @ORM\Column(type="datetime")
     */
    private $signedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastSeenAt;

    public function __construct()
    {
        $this->dogs = new ArrayCollection();
        $this->signedAt= new \DateTime();
        $this->lastSeenAt= new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    
    
    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDepartementCode(): ?int
    {
        return $this->departementCode;
    }

    public function setDepartementCode(int $departementCode): self
    {
        $this->departementCode = $departementCode;

        return $this;
    }

    public function getCircleRange(): ?int
    {
        return $this->circleRange;
    }

    public function setCircleRange(?int $circleRange): self
    {
        $this->circleRange = $circleRange;

        return $this;
    }

    /**
     * @return Collection|Dog[]
     */
    public function getDogs(): Collection
    {
        return $this->dogs;
    }

    public function addDog(Dog $dog): self
    {
        if (!$this->dogs->contains($dog)) {
            $this->dogs[] = $dog;
            $dog->setUser($this);
        }

        return $this;
    }

    public function removeDog(Dog $dog): self
    {
        if ($this->dogs->contains($dog)) {
            $this->dogs->removeElement($dog);
            // set the owning side to null (unless already changed)
            if ($dog->getUser() === $this) {
                $dog->setUser(null);
            }
        }

        return $this;
    }
    



    /**
     * Get the value of plainPassword
     */ 
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */ 
    public function setPlainPassword( string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getSignedAt(): ?\DateTimeInterface
    {
        return $this->signedAt;
    }

    public function setSignedAt(\DateTimeInterface $signedAt): self
    {
        $this->signedAt = $signedAt;

        return $this;
    }

    public function getLastSeenAt(): ?\DateTimeInterface
    {
        return $this->lastSeenAt;
    }

    public function setLastSeenAt(\DateTimeInterface $lastSeenAt): self
    {
        $this->lastSeenAt = $lastSeenAt;

        return $this;
    }
}
