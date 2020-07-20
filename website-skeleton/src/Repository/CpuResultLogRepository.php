<?php

namespace App\Repository;

use App\Entity\CpuResultLog;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method CpuResultLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method CpuResultLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method CpuResultLog[]    findAll()
 * @method CpuResultLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CpuResultLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CpuResultLog::class);
    }

    /**
     * @param int $result
     * @param string $today
     * @return int
     * @throws Exception
     */
    public function findCountByResultAndToday($result, $today)
    {
        $startedAt = new DateTime($today.' 00:00:00');
        $endedAt = new DateTime($today.' 23:59:59');

        $countResult = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from(CpuResultLog::class, 'c')
            ->where('c.result = :result AND c.createdAt >= :startedAt AND c.createdAt <= :endedAt')
            ->setParameters([
                'result' => $result,
                'startedAt' => $startedAt,
                'endedAt' => $endedAt,
            ])->getQuery()->getResult();
        return count($countResult);
    }

    // /**
    //  * @return CpuResultLog[] Returns an array of CpuResultLog objects
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
    public function findOneBySomeField($value): ?CpuResultLog
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
