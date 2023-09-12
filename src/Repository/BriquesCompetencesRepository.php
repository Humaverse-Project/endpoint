<?php

namespace App\Repository;

use App\Entity\BriquesCompetences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BriquesCompetences>
 *
 * @method BriquesCompetences|null find($id, $lockMode = null, $lockVersion = null)
 * @method BriquesCompetences|null findOneBy(array $criteria, array $orderBy = null)
 * @method BriquesCompetences[]    findAll()
 * @method BriquesCompetences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BriquesCompetencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BriquesCompetences::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BriquesCompetences $entity, bool $flush = true): void
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
    public function remove(BriquesCompetences $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function batchinsert(array $data) {
        $batchSize = 20;
        for ($i = 0; $i < count($data); ++$i) {
            $rome = new BriquesCompetences;
            $rome->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $rome->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $rome->setRome($data[$i]["rome"]);
            $rome->setCompGb($data[$i]["comp"]);
            $rome->setBrqCompTitre($data[$i]["brq_comp_titre"]);
            $this->_em->persist($rome);
            if (($i % $batchSize) === 0) {
                $this->_em->flush();
                $this->_em->clear();
            }
        }
        $this->_em->flush(); // Persist objects that did not make up an entire batch
        $this->_em->clear();
    }

    // /**
    //  * @return BriquesCompetences[] Returns an array of BriquesCompetences objects
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
    public function findOneBySomeField($value): ?BriquesCompetences
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
