<?php

namespace App\Repository;

use App\Entity\Clients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Clients|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clients|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clients[]    findAll()
 * @method Clients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clients::class);
    }

    // /**
    //  * @return Clients[] Returns an array of Clients objects
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

    
    public function findByFieldCelular($document, $celular): ?Clients
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Documento = :val')
            ->setParameter('val', $document)
            ->andWhere('c.Celular = :celular')
            ->setParameter('celular', $celular)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByFieldEmail($document, $email): ?Clients
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Documento = :val')
            ->setParameter('val', $document)
            ->andWhere('c.Email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
