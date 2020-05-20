<?php

namespace App\Controller;

use App\Entity\Medico;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PerfilMedicoController extends AbstractController
{
    /**
     * @Route("/perfil/medico", name="perfil_medico")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = 'select user.id as user_id, medico.id as medico_id , 
                        user.email,medico.nombre,medico.apellido,medico.cedula,
                        pais.pais,estado.estado,municipio.municipio,medico.direccion,medico.telefono 
                        from medico inner join user on user.id = medico.id_user_id 
                        inner join pais on pais.id = id_pais_id 
                        inner join estado on estado.id = id_estado_id 
                        inner join municipio on municipio.id = id_municipio_id;';

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        // Set parameters
        $statement->bindValue('status', 1);
        $statement->execute();

        $result = $statement->fetchAll();
        return $this->render('perfil_medico/index.html.twig', [
            'controller_name' => 'PerfilMedicoController',
                'medico'  => $result
        ]);
    }
}
