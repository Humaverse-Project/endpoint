<?php

namespace App\Repository;

use App\Entity\ConventionCollective;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConventionCollective>
 *
 * @method ConventionCollective|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConventionCollective|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConventionCollective[]    findAll()
 * @method ConventionCollective[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConventionCollectiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConventionCollective::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ConventionCollective $entity, bool $flush = true): void
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
    public function remove(ConventionCollective $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return ConventionCollective[] Returns an array of ConventionCollective objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ConventionCollective
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
