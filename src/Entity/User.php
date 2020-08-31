<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Entity;

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
 * @UniqueEntity(fields={"email"}, message="Please, choose another email")
 * @UniqueEntity(fields={"username"}, message="Please, choose another username")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, unique=true)
     *
     * @Assert\NotBlank(message="You must choose a username")
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage="The username should contain at least {{ limit }} characters",
     *     maxMessage="The username should not contain more than {{ limit }} characters",
     *     allowEmptyString=false
     * )
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30)
     *
     * @Assert\NotBlank(message="You must choose a lastname")
     * @Assert\Length(
     *     min=4,
     *     max=30,
     *     minMessage="The lastname should contain at least {{ limit }} characters",
     *     maxMessage="The lastname should not contain more than {{ limit }} characters",
     *     allowEmptyString=false
     * )
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30)
     *
     * @Assert\NotBlank(message="You must choose a firstname")
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage="The firstname should contain at least {{ limit }} characters",
     *     maxMessage="The firstname should not contain more than {{ limit }} characters",
     *     allowEmptyString=false
     * )
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, unique=true)
     *
     * @Assert\NotBlank(message="You must enter an email")
     * @Assert\Email(
     *     message="The email '{{ value }}' is not a valid email"
     * )
     */
    private $email;

    /**
     * @var string The hashed password
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="You must choose a Password")
     * @Assert\Length(
     *     min=5,
     *     max=255,
     *     minMessage="The Password should contain at least {{ limit }} characters",
     *     allowEmptyString=false
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
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): self
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
}
