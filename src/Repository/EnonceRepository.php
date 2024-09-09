<?php

namespace App\Repository;

use App\Entity\Enonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Enonce>
 *
 * @method Enonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enonce[]    findAll()
 * @method Enonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enonce::class);
    }

//    /**
//     * @return Enonce[] Returns an array of Enonce objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Enonce
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
