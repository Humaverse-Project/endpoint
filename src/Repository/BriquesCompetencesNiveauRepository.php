<?php

namespace App\Repository;

use App\Entity\BriquesCompetencesNiveau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BriquesCompetencesNiveau>
 *
 * @method BriquesCompetencesNiveau|null find($id, $lockMode = null, $lockVersion = null)
 * @method BriquesCompetencesNiveau|null findOneBy(array $criteria, array $orderBy = null)
 * @method BriquesCompetencesNiveau[]    findAll()
 * @method BriquesCompetencesNiveau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BriquesCompetencesNiveauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BriquesCompetencesNiveau::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BriquesCompetencesNiveau $entity, bool $flush = true): void
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
    public function remove(BriquesCompetencesNiveau $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return BriquesCompetencesNiveau[] Returns an array of BriquesCompetencesNiveau objects
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
    public function findOneBySomeField($value): ?BriquesCompetencesNiveau
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
