<?php

namespace App\Repository;

use App\Entity\SchemesTp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SchemesTp|null find($id, $lockMode = null, $lockVersion = null)
 * @method SchemesTp|null findOneBy(array $criteria, array $orderBy = null)
 * @method SchemesTp[]    findAll()
 * @method SchemesTp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchemesTpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SchemesTp::class);
    }

    // /**
    //  * @return UploadFile[] Returns an array of UploadFile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UploadFile
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
