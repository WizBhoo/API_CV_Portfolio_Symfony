<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entity Class User.
 *
 * @ORM\Table("user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @UniqueEntity(fields={"email"}, message="Please, choose another email", groups={"registration"})
 * @UniqueEntity(fields={"username"}, message="Please, choose another username", groups={"registration"})
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, unique=true)
     *
     * @Assert\NotBlank(message="You must choose a username", groups={"registration"})
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage="The username should contain at least {{ limit }} characters",
     *     maxMessage="The username should not contain more than {{ limit }} characters",
     *     allowEmptyString=false,
     *     groups={"registration"}
     * )
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30)
     *
     * @Assert\NotBlank(message="You must choose a lastname", groups={"registration", "profile"})
     * @Assert\Length(
     *     min=4,
     *     max=30,
     *     minMessage="The lastname should contain at least {{ limit }} characters",
     *     maxMessage="The lastname should not contain more than {{ limit }} characters",
     *     allowEmptyString=false,
     *     groups={"registration", "profile"}
     * )
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30)
     *
     * @Assert\NotBlank(message="You must choose a firstname", groups={"registration", "profile"})
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage="The firstname should contain at least {{ limit }} characters",
     *     maxMessage="The firstname should not contain more than {{ limit }} characters",
     *     allowEmptyString=false,
     *     groups={"registration", "profile"}
     * )
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, unique=true)
     *
     * @Assert\NotBlank(message="You must enter an email", groups={"registration"})
     * @Assert\Email(
     *     message="The email '{{ value }}' is not a valid email",
     *     groups={"registration"}
     * )
     */
    private $email;

    /**
     * @var string The hashed password
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="You must choose a Password", groups={"registration"})
     * @Assert\Length(
     *     min=5,
     *     max=255,
     *     minMessage="The Password should contain at least {{ limit }} characters",
     *     allowEmptyString=false,
     *     groups={"registration", "profile"}
     * )
     */
    private $password;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="author", orphanRemoval=true)
     */
    private $posts;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return $this
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return $this
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * The visual identifier that represents this user.
     *
     * @see UserInterface|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     *
     * @return $this
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = array_unique($roles);

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
    }

    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    /**
     * @param Post $post
     *
     * @return $this
     */
    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setAuthor($this);
        }

        return $this;
    }

    /**
     * @param Post $post
     *
     * @return $this
     */
    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }
}
