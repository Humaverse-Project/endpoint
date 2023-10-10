<?php

namespace App\Repository;

use App\Entity\BriquesContexteMetiers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BriquesContexteMetiers>
 *
 * @method BriquesContexteMetiers|null find($id, $lockMode = null, $lockVersion = null)
 * @method BriquesContexteMetiers|null findOneBy(array $criteria, array $orderBy = null)
 * @method BriquesContexteMetiers[]    findAll()
 * @method BriquesContexteMetiers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BriquesContexteMetiersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BriquesContexteMetiers::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BriquesContexteMetiers $entity, bool $flush = true): void
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
    public function remove(BriquesContexteMetiers $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return BriquesContexteMetiers[] Returns an array of BriquesContexteMetiers objects
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
    public function findOneBySomeField($value): ?BriquesContexteMetiers
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
