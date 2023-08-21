<?php

namespace App\Repository;

use App\Entity\PropositionPoste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PropositionPoste>
 *
 * @method PropositionPoste|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropositionPoste|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropositionPoste[]    findAll()
 * @method PropositionPoste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropositionPosteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropositionPoste::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PropositionPoste $entity, bool $flush = true): void
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
    public function remove(PropositionPoste $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return PropositionPoste[] Returns an array of PropositionPoste objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PropositionPoste
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
