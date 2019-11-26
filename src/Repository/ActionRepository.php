<?php

namespace App\Repository;

use App\Entity\Action;
use App\Entity\Room;
use App\Entity\Apartment;
use App\Entity\Building;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Action|null find($id, $lockMode = null, $lockVersion = null)
 * @method Action|null findOneBy(array $criteria, array $orderBy = null)
 * @method Action[]    findAll()
 * @method Action[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Action::class);
    }

    /**
     * @return array
     */
    public function all() {
        return $this->createQueryBuilder('ac')
            ->select(array('a as action', 'b.name as building', 'r.name as room', 'ap.name as apartment'))
            ->from(Action::class, 'a')
            ->innerJoin('a.building', 'b', 'WITH', 'b.id = a.building', 'b.id')
            ->innerJoin('a.apartment', 'ap', 'WITH', 'ap.id = a.apartment', 'ap.id')
            ->innerJoin('a.room', 'r', 'WITH', 'r.id = a.room', 'r.id')
            ->orderBy('a.date_of_work', 'DESC')
            ->distinct()
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return Object
     */
    public function arrayFind($id) {
        return $this->createQueryBuilder('ac')
            ->where('ac.id =' . $id)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Action[] Returns an array of Action objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Action
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
