<?php

namespace App\Repository;

use App\Entity\Medico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Medico|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medico|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medico[]    findAll()
 * @method Medico[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medico::class);
    }

    public function agregarEspecialidad($id_especialidad,$id_medico){
        $conn = $this->getEntityManager()->getConnection();
        $sql='
        insert into especialidad_medico values(:id_med,:id_esp);
        ';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_esp',$id_especialidad);
        $stmt->bindParam(':id_med',$id_medico);
        $stmt->execute();
    }

    // /**
    //  * @return Medico[] Returns an array of Medico objects
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
    public function findOneBySomeField($value): ?Medico
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
