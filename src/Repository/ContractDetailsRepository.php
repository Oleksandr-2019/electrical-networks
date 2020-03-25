<?php

namespace App\Repository;

use App\Entity\ContractDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ContractDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractDetails[]    findAll()
 * @method ContractDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractDetails::class);
    }

    /**
     * @return ContractDetails[]
     */
    public function findAllContract($testNameContract): array
    {



        $qb = $this->createQueryBuilder('variableAllContractInBase')
            ->where('variableAllContractInBase.nameContract LIKE :testNameContract')
            //->having('variableAllContractInBase.nameContract = :testNameContract')
            ->setParameter('testNameContract', $testNameContract . '%')
            //->setParameter('testNameContract', 'testNameContract%')
            ->orderBy('variableAllContractInBase.nameContract', 'ASC');

        $query = $qb->getQuery();

        return $query->execute();

















/*
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT id
            FROM App\Entity\ContractDetails
            WHERE nameContract LIKE findNameContract '
        )->setParameter('findNameContract', $findNameContract);

        // returns an array of Product objects
        return $query->getResult();
*/



    }

    // /**
    //  * @return ContractDetails[] Returns an array of ContractDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContractDetails
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
