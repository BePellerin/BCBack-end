<?php

namespace App\Repository;

use App\Entity\Collecs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Collecs>
 *
 * @method Collecs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collecs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collecs[]    findAll()
 * @method Collecs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollecsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collecs::class);
    }

//    /**
//     * @return Collecs[] Returns an array of Collecs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Collecs
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
