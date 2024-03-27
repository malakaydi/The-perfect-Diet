<?php

namespace App\Repository;

use App\Entity\PrpertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PrpertySearch>
 *
 * @method PrpertySearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrpertySearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrpertySearch[]    findAll()
 * @method PrpertySearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrpertySearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrpertySearch::class);
    }

//    /**
//     * @return PrpertySearch[] Returns an array of PrpertySearch objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PrpertySearch
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
