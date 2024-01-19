<?php

namespace App\Repository;

use App\Entity\QuantiteIngredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuantiteIngredient>
 *
 * @method QuantiteIngredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuantiteIngredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuantiteIngredient[]    findAll()
 * @method QuantiteIngredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuantiteIngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuantiteIngredient::class);
    }

//    /**
//     * @return QuantiteIngredient[] Returns an array of QuantiteIngredient objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?QuantiteIngredient
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
