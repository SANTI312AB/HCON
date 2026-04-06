<?php

namespace App\Repository;

use App\Entity\Medicamentos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Medicamentos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medicamentos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medicamentos[]    findAll()
 * @method Medicamentos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicamentosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medicamentos::class);
    }

    // /**
    //  * @return Medicamentos[] Returns an array of Medicamentos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Medicamentos
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


     // src/Repository/MedicamentosRepository.php

public function countAll()
{
    return $this->createQueryBuilder('m')
        ->select('count(m.id)')
        ->getQuery()
        ->getSingleScalarResult();
}

/**
 * Método optimizado para DataTables Server-Side
 */
// src/Repository/MedicamentosRepository.php

public function findForDatatables($start, $length, $search)
{
    $qb = $this->createQueryBuilder('m');

    // 1. Obtenemos el año más reciente (Subconsulta)
    // Usamos una subconsulta interna para que SQL Server lo resuelva en una sola ejecución
    $maxYearSubquery = $this->getEntityManager()->createQueryBuilder()
        ->select('MAX(m2.year)')
        ->from(Medicamentos::class, 'm2')
        ->getQuery()
        ->getSingleScalarResult();

    // 2. Seleccionamos los campos necesarios
    $qb->select('m.id', 'm.codigo', 'm.descripcion', 'm.principio_activo', 'm.laboratorio', 'm.year');

    // 3. Filtro por el año más reciente
    if ($maxYearSubquery) {
        $qb->andWhere('m.year = :maxYear')
           ->setParameter('maxYear', $maxYearSubquery);
    }

    // 4. Lógica de búsqueda (Filtro de DataTables)
    if (!empty($search)) {
        $qb->andWhere('(m.descripcion LIKE :s 
                       OR m.principio_activo LIKE :s 
                       OR m.Marca LIKE :s 
                       OR m.codigo LIKE :s)')
           ->setParameter('s', '%' . $search . '%');
    }

    // 5. Paginación y Orden
    return $qb->setFirstResult($start)
        ->setMaxResults($length)
        ->orderBy('m.descripcion', 'ASC')
        ->getQuery()
        ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
}
    public function medicamentos2()
    {
       $conn = $this->getEntityManager()
        ->getConnection();
        $sql = "SELECT MAX(s.year) FROM medicamentos s";
        $stmt = $conn->executeQuery($sql);
        $result = $stmt->fetch();
        return $this->createQueryBuilder('u')
        ->where('u.year = :identifier')
        ->setParameter('identifier', $result)
        ;
    }


    public function medicamentos()
    {
       /*$conn = $this->getEntityManager()
        ->getConnection();
        $sql = "SELECT MAX(s.year) FROM medicamentos s";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $at=dump($stmt->fetchAll());*/

        return $this->createQueryBuilder('u')
        ->select('u.id','u.codigo','u.descripcion','u.principio_activo','u.laboratorio','u.fraccion','u.Clasificacion','u.Marca','u.estado_producto','u.presentacion_producto','u.mercado','u.iva',
        'u.generico','u.portafolio_cat','u.observaciones','u.year')
        ->getQuery()
        ->getResult()
        ;
    }
}
