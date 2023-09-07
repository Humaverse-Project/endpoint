<?php

namespace App\Repository;

use App\Entity\FichersCompetencesClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FichersCompetencesClient>
 *
 * @method FichersCompetencesClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichersCompetencesClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichersCompetencesClient[]    findAll()
 * @method FichersCompetencesClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichersCompetencesClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichersCompetencesClient::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(FichersCompetencesClient $entity, bool $flush = true): void
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
    public function remove(FichersCompetencesClient $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return FichersCompetencesClient[] Returns an array of FichersCompetencesClient objects
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
    public function findOneBySomeField($value): ?FichersCompetencesClient
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
