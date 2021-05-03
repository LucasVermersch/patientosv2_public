<?php

namespace App\Repository;

use App\Entity\Sejour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sejour|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sejour|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sejour[]    findAll()
 * @method Sejour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SejourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sejour::class);
    }

    public function searchPurge(){
        return $this->createQueryBuilder('s')
            ->join('s.Patient','p')
            ->where('s.DateSortie < :dateActuel')
            ->andWhere('p.Lit is not NULL')
            ->andWhere(':dateActuel NOT BETWEEN s.DateEntree AND s.DateSortie')
            ->setParameter('dateActuel', date('Y-m-d'))
            ->getQuery()
            ->execute()
            ;

    }

    public function chercherLitOccupee(){
        return $this->createQueryBuilder('sejour')
            ->select('count(sejour.id)')
            ->andWhere(':dateActuel BETWEEN sejour.DateEntree AND sejour.DateSortie')
            ->setParameter('dateActuel', date('Y-m-d'))
            ->getQuery()
            ->execute()
            ;
    }
    public function chercherLitOccupeeDemain(){
        return $this->createQueryBuilder('sejour')
            ->select('count(sejour.id)')
            ->andWhere(':dateActuel BETWEEN sejour.DateEntree AND sejour.DateSortie')
            ->setParameter('dateActuel', date('Y-m-d', strtotime(date('Y-m-d').' + 1 DAY')))
            ->getQuery()
            ->execute()
            ;
    }
    public function chercherLitOccupeeJourMoins($nbJour){
        return $this->createQueryBuilder('sejour')
            ->select('count(sejour.id)')
            ->andWhere(':dateActuel BETWEEN sejour.DateEntree AND sejour.DateSortie')
            ->setParameter('dateActuel', date('Y-m-d', strtotime(date('Y-m-d').' - '. $nbJour.' DAY')))
            ->getQuery()
            ->execute()
            ;
    }
    public function chercherLitOccupeeJourPlus($nbJour){
        return $this->createQueryBuilder('sejour')
            ->select('count(sejour.id)')
            ->andWhere(':dateActuel BETWEEN sejour.DateEntree AND sejour.DateSortie')
            ->setParameter('dateActuel', date('Y-m-d', strtotime(date('Y-m-d').' + '. $nbJour.' DAY')))
            ->getQuery()
            ->execute()
            ;
    }

    // /**
    //  * @return Sejour[] Returns an array of Sejour objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sejour
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
