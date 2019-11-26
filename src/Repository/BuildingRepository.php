<?php

namespace App\Repository;

use App\Entity\Building;
use App\Entity\Apartment;
use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Building|null find($id, $lockMode = null, $lockVersion = null)
 * @method Building|null findOneBy(array $criteria, array $orderBy = null)
 * @method Building[]    findAll()
 * @method Building[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Building::class);
    }

    public function findAllWithArray()
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('b')
            ->from(Building::class, 'b')
            ->orderBy('b.name', 'DESC');

        $query = $qb->getQuery();
        return $query->getArrayResult();
    }

    public function findBuildingsWithRooms() {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->join(Apartment::class, 'ap', 'WITH', 'b = ap.building')
            ->join(Room::class, 'r', 'WITH', 'ap = r.apartment')
            ->orderBy('b.name', 'DESC')
            ->distinct()
            ->getQuery()
            ->getArrayResult();
    }

    public function findOneByIdJoinedToBuilding($id)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT a FROM App\Entity\Apartment a
             WHERE a.building = :id'
        )->setParameter('id', $id);

        return $query->getArrayResult();
    }

    // /**
    //  * @return Building[] Returns an array of Building objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Building
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
