<?php

namespace App\Repository;

use App\Entity\BankTransactionPart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BankTransactionPart|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankTransactionPart|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankTransactionPart[]    findAll()
 * @method BankTransactionPart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankTransactionPartRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BankTransactionPart::class);
    }

    // /**
    //  * @return BankTransactionPart[] Returns an array of BankTransactionPart objects
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
    public function findOneBySomeField($value): ?BankTransactionPart
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
