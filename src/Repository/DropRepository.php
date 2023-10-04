<?php

namespace App\Repository;

use App\Entity\Drop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Drop>
 *
 * @method Drop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Drop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Drop[]    findAll()
 * @method Drop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DropRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Drop::class);
    }

//    /**
//     * @return Drop[] Returns an array of Drop objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Drop
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
