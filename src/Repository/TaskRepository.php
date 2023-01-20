<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    CONST ENTITY_ROUTE        = "App\Entity\Task";

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function save(Task $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Task $entity, bool $flush = false): void
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
        
        if(isset($params["name"])){
            $queries[] = "(task.name LIKE '{$params['name']}%') ";
        }
        if(isset($params["taskTypeId"])){
            $queries[] = "(task.taskType = :taskTypeId)";
            $queryParams["taskTypeId"] = $params["taskTypeId"];
        }
        return $entityManager
        ->createQuery($this->buildQueryWithSubQueries("SELECT task FROM $entityRoute task",$queries))
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
//     * @return Task[] Returns an array of Task objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Task
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
