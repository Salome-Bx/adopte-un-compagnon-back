<?php

namespace App\Repository;

use App\Entity\Pet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pet>
 */
class PetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pet::class);
    }

//    /**
//     * @return Pet[] Returns an array of Pet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Pet
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findBySOS(): array 
    {
        $pets= new Pet;
        $pets = $this->findBy(["sos" => 1]);
        return $pets;
        
    }

    // public function findAllPetsByAsso(EntityManagerInterface $em): array
    // {
    //     $assoId = $this->getAsso($em);

    //     $queryBuilder = $em->createQueryBuilder();
    //     $queryBuilder->select('p')
    //         ->from(Pet::class, 'p')
    //         ->join('p.asso_id', 'a')
    //         ->where('a.id = :assoId')
    //         ->setParameter('assoId', $assoId);

    //     return $queryBuilder->getQuery()->getResult();
    // }

    
}