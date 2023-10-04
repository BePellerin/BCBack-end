<?php

namespace App\Repository;

use App\Entity\AirDrop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AirDrop>
 *
 * @method AirDrop|null find($id, $lockMode = null, $lockVersion = null)
 * @method AirDrop|null findOneBy(array $criteria, array $orderBy = null)
 * @method AirDrop[]    findAll()
 * @method AirDrop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AirDropRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AirDrop::class);
    }

//    /**
//     * @return AirDrop[] Returns an array of AirDrop objects
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

//    public function findOneBySomeField($value): ?AirDrop
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
