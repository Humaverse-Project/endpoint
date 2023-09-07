<?php

namespace App\Repository;

use App\Entity\FichesPostesGenerique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FichesPostesGenerique>
 *
 * @method FichesPostesGenerique|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichesPostesGenerique|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichesPostesGenerique[]    findAll()
 * @method FichesPostesGenerique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichesPostesGeneriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichesPostesGenerique::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(FichesPostesGenerique $entity, bool $flush = true): void
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
    public function remove(FichesPostesGenerique $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return FichesPostesGenerique[] Returns an array of FichesPostesGenerique objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FichesPostesGenerique
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
