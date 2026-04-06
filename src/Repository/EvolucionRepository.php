<?php

namespace App\Repository;

use App\Entity\Evolucion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evolucion>
 *
 * @method Evolucion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evolucion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evolucion[]    findAll()
 * @method Evolucion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvolucionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evolucion::class);
    }

//    /**
//     * @return Evolucion[] Returns an array of Evolucion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evolucion
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
