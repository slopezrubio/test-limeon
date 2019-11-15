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
            ->select(array('b.name', 'ap.name', 'r.name'))
            ->from(Action::class, 'a')
            ->innerJoin(Building::class, 'b', 'WITH', 'b.id = a.building')
            ->innerJoin(Room::class, 'r', 'WITH', 'r.id = a.room')
            ->innerJoin(Apartment::class,'ap', 'WITH', 'ap.id = a.apartment')
            ->orderBy('a.date_of_work', 'DESC')
            ->getQuery()
            ->getArrayResult();
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
