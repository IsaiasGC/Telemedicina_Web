<?php

namespace App\Repository;

use App\Entity\Consulta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Consulta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consulta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consulta[]    findAll()
 * @method Consulta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consulta::class);
    }

    // /**
    //  * @return Consulta[] Returns an array of Consulta objects
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
    public function findOneBySomeField($value): ?Consulta
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function consultas($id_paciente): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        select consulta.id , consulta.sintomas, consulta.foto_sintomas, especialidad.especialidad
        from consulta 
            inner join paciente on consulta.id_paciente_id = paciente.id
            inner join especialidad on consulta.id_especialidad_id = especialidad.id
            where paciente.id = :id;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id_paciente]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
}
