<?php

namespace App\Repository;

use App\Entity\Rome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rome>
 *
 * @method Rome|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rome|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rome[]    findAll()
 * @method Rome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rome::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Rome $entity, bool $flush = true): void
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
    public function remove(Rome $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function batchinsert(array $data) {
        $batchSize = 20;
        for ($i = 0; $i < count($data); ++$i) {
            $rome = new Rome;
            $rome->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $rome->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $rome->setRomeAccesMetier($data[$i]["accesEmploi"]);
            $rome->setRomeCoderome($data[$i]["code"]);
            $rome->setRomeTitre($data[$i]["libelle"]);
            $rome->setRomeDefinition($data[$i]["definition"]);
            $this->_em->persist($rome);
            if (($i % $batchSize) === 0) {
                $this->_em->flush();
                $this->_em->clear();
            }
        }
        $this->_em->flush(); // Persist objects that did not make up an entire batch
        $this->_em->clear();
    }

    public function batchupdate(array $data) {
        $batchSize = 20;
        for ($i = 0; $i < count($data); ++$i) {
            $rome = $data[$i];
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
    //  * @return Rome[] Returns an array of Rome objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rome
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
