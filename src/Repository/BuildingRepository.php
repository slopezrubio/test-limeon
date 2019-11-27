<?php

namespace App\Repository;

use App\Entity\Building;
use App\Entity\Apartment;
use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;
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

    /**
     * SELECT * FROM buildings ORDER BY b.name DESC
     *
     * @return array|null
     */
    public function findAllWithArray(): ?array
    {
        return $this->createQueryBuilder()
            ->select('b')
            ->from(Building::class, 'b')
            ->orderBy('b.name', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * SELECT DISTINCT * FROM buildings b JOIN apartments ap JOIN rooms r
     * WHERE ap.building_id = b.id AND WHERE ap.id = r.apartment_id
     * ORDER BY b.name ASC
     *
     * @return array|null
     */
    public function findBuildingsWithRooms(): ?array {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->innerJoin(Apartment::class, 'ap')
            ->innerJoin(Room::class, 'r')
            ->where('b.id = ap.building')
            ->andWhere('ap.id = r.apartment' )
            ->orderBy('b.name', 'ASC')
            ->distinct()
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * SELECT * FROM apartment a WHERE a.building = $id
     *
     * @param $id
     * @return array
     */
    public function findOneByIdJoinedToBuilding($id): ?array
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
