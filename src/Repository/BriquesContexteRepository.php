<?php

namespace App\Repository;

use App\Entity\BriquesContexte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BriquesContexte>
 *
 * @method BriquesContexte|null find($id, $lockMode = null, $lockVersion = null)
 * @method BriquesContexte|null findOneBy(array $criteria, array $orderBy = null)
 * @method BriquesContexte[]    findAll()
 * @method BriquesContexte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BriquesContexteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BriquesContexte::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BriquesContexte $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(BriquesContexte $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return BriquesContexte[] Returns an array of BriquesContexte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BriquesContexte
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
