<?php

namespace App\Repository;

use App\Entity\Paciente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Paciente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paciente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paciente[]    findAll()
 * @method Paciente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PacienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paciente::class);
    }

    // /**
    //  * @return Paciente[] Returns an array of Paciente objects
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


    public function findOneBySomeField($value): ?Paciente
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id_user = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function pacienteActual($email): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        select user.id as user_id, paciente.id as paciente_id ,
                            user.email,paciente.nombre,paciente.apellido,paciente.alergias,paciente.enfermedades_cronicas,paciente.cirugias,
                            pais.pais,estado.estado,municipio.municipio,paciente.direccion,paciente.telefono
                            from paciente inner join user on user.id = paciente.id_user_id
                            inner join pais on pais.id = id_pais_id
                            inner join estado on estado.id = id_estado_id
                            inner join municipio on municipio.id = id_municipio_id where user.email = :email;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
}
