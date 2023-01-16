<?php

namespace App\Repository;

use App\Entity\SummaryDataTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SummaryDataTask>
 *
 * @method SummaryDataTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method SummaryDataTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method SummaryDataTask[]    findAll()
 * @method SummaryDataTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SummaryDataTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SummaryDataTask::class);
    }

    public function save(SummaryDataTask $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SummaryDataTask $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SummaryDataTask[] Returns an array of SummaryDataTask objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SummaryDataTask
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
