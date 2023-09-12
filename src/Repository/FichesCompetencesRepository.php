<?php

namespace App\Repository;

use App\Entity\FichesCompetences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FichesCompetences>
 *
 * @method FichesCompetences|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichesCompetences|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichesCompetences[]    findAll()
 * @method FichesCompetences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichesCompetencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichesCompetences::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(FichesCompetences $entity, bool $flush = true): void
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
    public function remove(FichesCompetences $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return FichesCompetences[] Returns an array of FichesCompetences objects
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
    public function findOneBySomeField($value): ?FichesCompetences
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
