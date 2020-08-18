<?php

namespace App\Repository;

use App\Entity\CPULogs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CPULogs|null find($id, $lockMode = null, $lockVersion = null)
 * @method CPULogs|null findOneBy(array $criteria, array $orderBy = null)
 * @method CPULogs[]    findAll()
 * @method CPULogs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CPULogsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CPULogs::class);
    }

    // /**
    //  * @return CPULogs[] Returns an array of CPULogs objects
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
    public function findOneBySomeField($value): ?CPULogs
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
