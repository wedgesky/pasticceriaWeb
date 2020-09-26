<?php

namespace App\Repository;

use App\Entity\Dessert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Dessert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dessert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dessert[]    findAll()
 * @method Dessert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DessertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dessert::class);
    }

    // /**
    //  * @return Dessert[] Returns an array of Dessert objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    /**
     * @return Dessert[] Returns an array of Ingredient objects
     */
    public function findFeaturedList()
    {
        $dayBeforeDBY = new \DateTime();
        $dayBeforeDBY->setTime(0,0,0);
        date_sub($dayBeforeDBY,date_interval_create_from_date_string("3 days"));
        $tomorrow = new \DateTime();
        date_add($tomorrow, date_interval_create_from_date_string("1 days"));
        $tomorrow->setTime(0,0,0);

        return $this->createQueryBuilder('i')
            ->andWhere('i.obsolete = 0')
            ->andWhere('i.dateSell IS not null')
            ->andWhere('i.dateSell < :tomorrow')
            ->andWhere('i.dateSell > :dayBeforeDBY')
            ->setParameter('tomorrow', $tomorrow, \Doctrine\DBAL\Types\Type::DATETIME)
            ->setParameter('dayBeforeDBY', $dayBeforeDBY, \Doctrine\DBAL\Types\Type::DATETIME)
            ->orderBy('i.id', 'DESC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Dessert[] Returns an array of Ingredient objects
     */
    public function findObsoleteList()
    {
        $dayBeforeYesterday = new \DateTime();
        $dayBeforeYesterday->setTime(0,0,0);
        date_sub($dayBeforeYesterday,date_interval_create_from_date_string("2 days"));

        return $this->createQueryBuilder('i')
            ->andWhere('i.obsolete = 0')
            ->andWhere('i.dateSell IS not null')
            ->andWhere('i.dateSell < :dayBeforeYesterday')
            ->setParameter('dayBeforeYesterday', $dayBeforeYesterday, \Doctrine\DBAL\Types\Type::DATETIME)
            ->orderBy('i.id', 'DESC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }


    public function findOneById($value): ?Dessert
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
