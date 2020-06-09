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

    public function obtenerConsultaAtendida($id_medico,$id_consulta){
        //select paciente.nombre, paciente.covid19,consulta.sintomas,consulta.foto_sintomas,consulta.sintomas,especialidad.especialidad,CA.diagnostico, CA.fecha_atencion from medico inner join consulta_atendida CA on medico.id = CA.id_medico inner join consulta on consulta.id = CA.id_consulta inner join paciente on consulta.id_paciente_id = paciente.id inner join especialidad on consulta.id_especialidad_id = especialidad.id;
        $em = $this->getEntityManager()->getConnection();
        $queryChida="select CA.medicamento,concat(medico.nombre,' ',medico.apellido) as nombreMedico ,paciente.alergias,paciente.enfermedades_cronicas,paciente.cirugias,user.email,consulta.id as id_consulta, concat(paciente.nombre,' ',paciente.apellido) as nombre,paciente.covid19,consulta.foto_sintomas,consulta.sintomas,especialidad.especialidad,CA.diagnostico, CA.fecha_atencion from medico inner join consulta_atendida CA on medico.id = CA.id_medico inner join consulta on consulta.id = CA.id_consulta inner join paciente on consulta.id_paciente_id = paciente.id inner join especialidad on consulta.id_especialidad_id = especialidad.id inner join user on user.id = paciente.id_user_id where medico.id = :id and consulta.id = :id_consulta;";
        $statement = $em->prepare($queryChida);
        $statement->bindParam(':id', $id_medico);
        $statement->bindParam(':id_consulta', $id_consulta);
        $statement->execute();
        $consultas = $statement->fetchAll();
        return $consultas;
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
