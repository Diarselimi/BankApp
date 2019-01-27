<?php

namespace App\Repository;

use App\Entity\BankTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BankTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankTransaction[]    findAll()
 * @method BankTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankTransactionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BankTransaction::class);
    }

    // /**
    //  * @return BankTransaction[] Returns an array of BankTransaction objects
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
    public function findOneBySomeField($value): ?BankTransaction
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
