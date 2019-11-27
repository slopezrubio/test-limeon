<?php

namespace App\Repository;

use App\Entity\Apartment;
use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Apartment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apartment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apartment[]    findAll()
 * @method Apartment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apartment::class);
    }

    /**
     * SELECT * FROM apartment ap WHERE $field = $value
     *
     * @param $field
     * @param $value
     * @return array
     */
    public function findByField($field, $value) {
        return $this->createQueryBuilder('a')
            ->andWhere('a.:field = :val')
            ->setParameters(array('field' => $field, 'val' => $value))
            ->orderBy('a.name', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * SELECT DISTINCT * FROM apartment ap JOIN rooms r ON ap.id = r.apartment_id
     * WHERE ap.building_id = $building
     *
     * @param $building
     * @return array
     */
    public function findByBuilding($building) {
        return $this->createQueryBuilder('a')
            ->join(Room::class, 'r', 'WITH', 'a.id = r.apartment')
            ->where('a.building = :val')
            ->setParameter('val', $building)
            ->orderBy('a.name', 'ASC')
            ->distinct()
            ->getQuery()
            ->getArrayResult();
    }

    // /**
    //  * @return Apartment[] Returns an array of Apartment objects
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
    public function findOneBySomeField($value): ?Apartment
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
