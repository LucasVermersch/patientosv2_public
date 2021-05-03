<?php

namespace App\Repository;

use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }
    public function search($nom,$prenom) {
        return $this->createQueryBuilder('patient')
            ->where('patient.Nom LIKE :nom')
            ->andWhere('patient.Prenom LIKE :prenom')
            ->andWhere('patient.Lit is not NULL')
            ->setParameter('nom', '%'.$nom.'%')
            ->setParameter('prenom', '%'.$prenom.'%')
            ->getQuery()
            ->execute();
    }

    public function searchSejour($nom,$prenom) {
        return $this->createQueryBuilder('patient')
            ->andWhere('patient.Nom LIKE :nom')
            ->andWhere('patient.Prenom LIKE :prenom')
            ->andWhere('patient.Lit is NULL')
            ->setParameter('nom', '%'.$nom.'%')
            ->setParameter('prenom', '%'.$prenom.'%')
            ->getQuery()
            ->execute();
    }

    public function searchClassique() {
        return $this->createQueryBuilder('patient')
            ->where('patient.Lit is not null')
            ->getQuery()
            ->execute();
    }
    public function searchClassiqueSejour() {
        return $this->createQueryBuilder('patient')
            ->where('patient.Lit is null')
            ->getQuery()
            ->execute();
    }
}
