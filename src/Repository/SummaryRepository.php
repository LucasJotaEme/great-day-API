<?php

namespace App\Repository;

use App\Entity\Summary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Summary>
 *
 * @method Summary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Summary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Summary[]    findAll()
 * @method Summary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SummaryRepository extends ServiceEntityRepository
{

    CONST ENTITY_ROUTE = "App\Entity\Summary";

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Summary::class);
    }

    public function save(Summary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Summary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByParamsWithQuery($params): Array
    {
        $entityRoute         = self::ENTITY_ROUTE;
        $entityManager       = $this->getEntityManager();
        $queryParams         = array();
        $queries             = array();
        if(isset($params["firstDate"])){
            $queries[] = "(summary.creationDate >= :firstDate AND summary.creationDate <= :secondDate)";
            $queryParams["firstDate"]  = $params["firstDate"]->format('Y-m-d H:i:s');
            $queryParams["secondDate"] = $params["secondDate"]->format('Y-m-d H:i:s');
        }
        if(isset($params["userId"])){
            $queries[] = "(summary.user = :userId)";
            $queryParams["userId"] = $params["userId"];
        }
        return $entityManager
        ->createQuery($this->buildQueryWithSubQueries("SELECT summary FROM $entityRoute summary",$queries))
        ->setParameters($queryParams)
        ->getResult();
    }

    private function buildQueryWithSubQueries($query, $queries){
        foreach($queries as $position => $queryInArray){
            $query .= $position === 0 ? " WHERE $queryInArray" : " AND $queryInArray";
        }
        return $query;
    }

//    /**
//     * @return Summary[] Returns an array of Summary objects
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

//    public function findOneBySomeField($value): ?Summary
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
