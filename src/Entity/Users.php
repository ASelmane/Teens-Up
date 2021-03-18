<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $ddn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $distance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_location;

    /**
     * @ORM\ManyToMany(targetEntity=Sports::class, inversedBy="users")
     */
    private $sport;

    /**
     * @ORM\OneToMany(targetEntity=Likes::class, mappedBy="users", orphanRemoval=true)
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity=Likes::class, mappedBy="users_liked", orphanRemoval=true)
     */
    private $likedBy;

    public function __construct()
    {
        $this->sport = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->likedBy = new ArrayCollection();
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
        return (string) $this->email;
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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDdn(): ?\DateTimeInterface
    {
        return $this->ddn;
    }

    public function setDdn(\DateTimeInterface $ddn): self
    {
        $this->ddn = $ddn;

        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(string $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getLastLocation(): ?string
    {
        return $this->last_location;
    }

    public function setLastLocation(string $last_location): self
    {
        $this->last_location = $last_location;

        return $this;
    }

    /**
     * @return Collection|Sports[]
     */
    public function getSport(): Collection
    {
        return $this->sport;
    }

    public function addSport(Sports $sport): self
    {
        if (!$this->sport->contains($sport)) {
            $this->sport[] = $sport;
        }

        return $this;
    }

    public function removeSport(Sports $sport): self
    {
        $this->sport->removeElement($sport);

        return $this;
    }

    public function getAge()
    {
        $dateInterval = $this->ddn->diff(new \DateTime());
 
        return $dateInterval->y;
    }

    function getDistanceOpt($latitudeFrom, $longitudeFrom)
    {
        $rad = M_PI / 180;
        $location = explode(';', $this->last_location);
        $latitudeTo = $location[0];
        $longitudeTo = $location[1];

        //Calculate distance from latitude and longitude
        $theta = $longitudeFrom - $longitudeTo;
        $dist = sin($latitudeFrom * $rad) 
            * sin($latitudeTo * $rad) +  cos($latitudeFrom * $rad)
            * cos($latitudeTo * $rad) * cos($theta * $rad);

        return round(acos($dist) / $rad * 60 *  1.853);
    }

    /**
     * @return Collection|Likes[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Likes $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setUsers($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getUsers() === $this) {
                $like->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Likes[]
     */
    public function getLikedBy(): Collection
    {
        return $this->likedBy;
    }

    public function addLikedBy(Likes $likedBy): self
    {
        if (!$this->likedBy->contains($likedBy)) {
            $this->likedBy[] = $likedBy;
            $likedBy->setUsersLiked($this);
        }

        return $this;
    }

    public function removeLikedBy(Likes $likedBy): self
    {
        if ($this->likedBy->removeElement($likedBy)) {
            // set the owning side to null (unless already changed)
            if ($likedBy->getUsersLiked() === $this) {
                $likedBy->setUsersLiked(null);
            }
        }

        return $this;
    }
}
