<?php

namespace App\Repository;

use App\Entity\ProductInvoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductInvoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductInvoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductInvoice[]    findAll()
 * @method ProductInvoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductInvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductInvoice::class);
    }

    // /**
    //  * @return ProductInvoice[] Returns an array of ProductInvoice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductInvoice
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
