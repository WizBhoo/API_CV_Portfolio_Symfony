<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserRepository.
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Persists new User in db.
     *
     * @param User $user
     *
     * @return void
     *
     * @throws ORMException|OptimisticLockException
     */
    public function create(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Persists User updated in db.
     *
     * @param UserInterface $user
     *
     * @return void
     *
     * @throws ORMException|OptimisticLockException
     */
    public function update(UserInterface $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Remove User in db.
     *
     * @param User $user
     *
     * @return void
     *
     * @throws ORMException|OptimisticLockException
     */
    public function delete(User $user): void
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}
