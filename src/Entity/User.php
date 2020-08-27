<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entity Class User.
 *
 * @ORM\Table("user")
 * @ORM\Entity
 *
 * @UniqueEntity(fields={"email"}, message="This email already exists")
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
     * @Assert\NotBlank(message="You must choose a Username")
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage="Your username should contain at least {{ limit }} characters",
     *     maxMessage="Your username should not contain more than {{ limit }} characters",
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
     *     minMessage="Your lastname should contain at least {{ limit }} characters",
     *     maxMessage="Your lastname should not contain more than {{ limit }} characters",
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
     *     minMessage="Your firstname should contain at least {{ limit }} characters",
     *     maxMessage="Your firstname should not contain more than {{ limit }} characters",
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
     *     minMessage="Your Password should contain at least {{ limit }} characters",
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
     * Token used for account activation or to reset account password.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $accountToken;

    /**
     * To manage token validity period.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $accountTokenAt;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default"=false})
     */
    private $accountStatus = false;

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
     * @return string|null
     */
    public function getAccountToken(): ?string
    {
        return $this->accountToken;
    }

    /**
     * @param string|null $accountToken
     *
     * @return $this
     */
    public function setAccountToken(?string $accountToken): self
    {
        $this->accountToken = $accountToken;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getAccountTokenAt(): ?DateTimeInterface
    {
        return $this->accountTokenAt;
    }

    /**
     * @param DateTimeInterface|null $accountTokenAt
     *
     * @return $this
     */
    public function setAccountTokenAt(?DateTimeInterface $accountTokenAt): self
    {
        $this->accountTokenAt = $accountTokenAt;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAccountStatus(): ?bool
    {
        return $this->accountStatus;
    }

    /**
     * @param bool $accountStatus
     *
     * @return $this
     */
    public function setAccountStatus(bool $accountStatus): self
    {
        $this->accountStatus = $accountStatus;

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
        $this->accountToken = null;
        $this->accountTokenAt = null;
    }
}
