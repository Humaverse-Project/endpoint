<?php

namespace App\Repository;

use App\Entity\FichesPostes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FichesPostes>
 *
 * @method FichesPostes|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichesPostes|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichesPostes[]    findAll()
 * @method FichesPostes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichesPostesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichesPostes::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(FichesPostes $entity, bool $flush = true): void
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
    public function remove(FichesPostes $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function fitrefichesposte(string $titre, int $entreprise): ?array
    {
        $query = $this->_em->createQuery('
            SELECT f
            FROM App\Entity\FichesPostes f
            WHERE f.fiches_postes_titre LIKE :titre
            AND (f.fiches_postes_entreprise IS NULL OR f.fiches_postes_entreprise = :entreprise)
        ')
        ->setParameter('titre', $titre . '%')
        ->setParameter('entreprise', $entreprise);

        $result = $query->getResult();
        return $result;
    }

    /*
    public function findOneBySomeField($value): ?FichesPostes
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
