<?php

namespace App\Repository;

use App\Entity\CompetencesGlobales;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompetencesGlobales>
 *
 * @method CompetencesGlobales|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetencesGlobales|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetencesGlobales[]    findAll()
 * @method CompetencesGlobales[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetencesGlobalesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompetencesGlobales::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CompetencesGlobales $entity, bool $flush = true): void
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
    public function remove(CompetencesGlobales $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function batchinsert(array $data) {
        $batchSize = 20;
        for ($i = 0; $i < count($data); ++$i) {
            $rome = new CompetencesGlobales;
            $rome->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $rome->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $rome->setCompGbCategorie($data[$i]["comp_gb_categorie"]);
            $rome->setCompGbTitre($data[$i]["comp_gb_titre"]);
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
    //  * @return CompetencesGlobales[] Returns an array of CompetencesGlobales objects
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
    public function findOneBySomeField($value): ?CompetencesGlobales
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
