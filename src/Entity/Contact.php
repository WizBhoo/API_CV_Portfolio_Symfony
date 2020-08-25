<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entity Class Contact.
 */
class Contact
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="You must add a firstname")
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage="The firstname should contain at least {{ limit }} characters",
     *     maxMessage="The firstname should not contain more than {{ limit }} characters"
     * )
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="You must add a lastname")
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage="The lastname should contain at least {{ limit }} characters",
     *     maxMessage="The lastname should not contain more than {{ limit }} characters"
     * )
     */
    private $lastname;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="You must add a subject")
     * @Assert\Length(
     *     min=3,
     *     max=60,
     *     minMessage="The subject should contain at least {{ limit }} characters",
     *     maxMessage="The subject should not contain more than {{ limit }} characters"
     * )
     */
    private $subject;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="You must add an email")
     * @Assert\Email(message="The Email '{{ value }}' is not a valid email")
     */
    private $email;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="Your message can't be empty")
     * @Assert\Length(
     *     min=10,
     *     minMessage="Your message should contain at least {{ limit }} characters"
     * )
     */
    private $message;

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     *
     * @return Contact
     */
    public function setFirstname(?string $firstname): Contact
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     *
     * @return Contact
     */
    public function setLastname(?string $lastname): Contact
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string|null $subject
     *
     * @return Contact
     */
    public function setSubject(?string $subject): Contact
    {
        $this->subject = $subject;

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
     * @param string|null $email
     *
     * @return Contact
     */
    public function setEmail(?string $email): Contact
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     *
     * @return Contact
     */
    public function setMessage(?string $message): Contact
    {
        $this->message = $message;

        return $this;
    }
}
