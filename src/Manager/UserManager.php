<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserManager.
 */
class UserManager
{
    /**
     * A UserRepository Instance.
     *
     * @var UserRepository
     */
    private $userRepository;

    /**
     * A PasswordEncoderInterface Injection.
     *
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserManager constructor.
     *
     * @param UserRepository               $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Retrieve all users from db.
     *
     * @return User[]
     */
    public function findAllUsers(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * Create a new User in db.
     *
     * @param User $user
     *
     * @return void
     *
     * @throws ORMException|OptimisticLockException
     */
    public function createUser(User $user): void
    {
        $password = $this->passwordEncoder->encodePassword(
            $user,
            $user->getPassword()
        );
        $user->setPassword($password);

        $this->userRepository->create($user);
    }

    /**
     * Switch User's role in db (Admin or User).
     *
     * @param User $user
     *
     * @return void
     *
     * @throws ORMException|OptimisticLockException
     */
    public function switchRole(User $user): void
    {
        switch ($user->getRoles()) {
            case ['ROLE_ADMIN']:
                $user->setRoles(['ROLE_USER']);
                break;
            case ['ROLE_USER']:
                $user->setRoles(['ROLE_ADMIN']);
        }

        $this->userRepository->update($user);
    }

    /**
     * Delete a User in db.
     *
     * @param User $user
     *
     * @return void
     *
     * @throws ORMException|OptimisticLockException
     */
    public function deleteUser(User $user): void
    {
        $this->userRepository->delete($user);
    }
}
