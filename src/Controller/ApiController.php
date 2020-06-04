<?php

namespace App\Controller;

use App\Entity\Consulta;
use App\Entity\Especialidad;
use App\Entity\Paciente;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    /**
     * @Route("/api/consultasPaciente", name="apiConsultasPaciente", methods={"POST"})
     */
    public function mostrarConsultas(Request $request){
        //Revise un json unicamente con el id de paciente
        $data = $request->getContent();
        $decode = json_decode($data,true);
        $id_paciente = $decode['id_paciente'];
        $consultas = $this->consultas($id_paciente);
        return new Response(json_encode($consultas));
        //Te regresa los campos de la consulta, ejemplo:
        /*
         * [
                {
                    "id": "1",
                    "sintomas": "PEKOPEKO",
                    "foto_sintomas": "screenshot-from-2020-05-21-18-45-05-5ed189311e6de.png",
                    "especialidad": "ANATOMIA PATOLOGICA"
                },
                {
                    "id": "2",
                    "sintomas": "Comezon en la piel. ardor en la cara",
                    "foto_sintomas": null,
                    "especialidad": "HEMATOLOGIA"
                },
                {
                    "id": "3",
                    "sintomas": "Dificultad para dormir",
                    "foto_sintomas": "screenshot-from-2020-03-26-15-12-49-5ed28d6f63c94.png",
                    "especialidad": "GASTROENTERLOGIA-DIGESTIVO"
                },
                {
                    "id": "4",
                    "sintomas": "MUCHAS COSAS",
                    "foto_sintomas": null,
                    "especialidad": "ANATOMIA PATOLOGICA"
                },
                {
                    "id": "5",
                    "sintomas": "Muchos granos por aqui",
                    "foto_sintomas": "culturanahuatl-5ed57e31924f7.jpeg",
                    "especialidad": "ANATOMIA PATOLOGICA"
                }
            ]
         */

    }

    /**
     * @Route("/api/consultasPacienteAte", name="apiConsultasPacienteAte", methods={"POST"})
     */
    public function mostrarConsultasAte(Request $request)
    {
        //Revise un json unicamente con el id de paciente
        $data = $request->getContent();
        $decode = json_decode($data, true);
        $id_paciente = $decode['id_paciente'];
        $consultas = $this->obtenerConsultaAtendidas($id_paciente);
        return new Response(json_encode($consultas));
    }


    /**
     * @Route("/api/consultasCrear", name="apiConsultasCrear", methods={"POST"})
     */
    public function crearConsulta(Request $request)
    {
        //Revise un json con todos los datos de la consulta, ejemplo:
        /*
         * {
	            "id_paciente":4,
	            "sintomas":"me duele el ombligo",
	            "id_especialidad":10
            }
         */
        $data = $request->getContent();
        $decode = json_decode($data, true);
        $id_paciente = $decode['id_paciente'];
        $sintomas = $decode['sintomas'];
        $id_especialidad = $decode['id_especialidad'];
        $consulta = new Consulta();
        $consulta->setIdPaciente($this
            ->getDoctrine()
            ->getRepository(Paciente::class)
            ->find($id_paciente));
        $consulta->setSintomas($sintomas);
        $consulta->setIdEspecialidad($this
            ->getDoctrine()
            ->getRepository(Especialidad::class)
            ->find($id_especialidad));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($consulta);
        $entityManager->flush();

        return new Response("Consulta creada con exito, tal vez");
    }

    public function consultas($id_paciente): array
    {
        $consultas = $this->getDoctrine()
            ->getRepository(Consulta::class)
            ->consultas($id_paciente);
        // returns an array of arrays (i.e. a raw data set)
        return $consultas;
    }

    public function obtenerConsultaAtendidas($paciente): array {
        //select paciente.nombre, paciente.covid19,consulta.sintomas,consulta.foto_sintomas,consulta.sintomas,especialidad.especialidad,CA.diagnostico, CA.fecha_atencion from medico inner join consulta_atendida CA on medico.id = CA.id_medico inner join consulta on consulta.id = CA.id_consulta inner join paciente on consulta.id_paciente_id = paciente.id inner join especialidad on consulta.id_especialidad_id = especialidad.id;
        $em = $this->getDoctrine()->getManager();
        $queryChida="select consulta.id as id_consulta, paciente.nombre,paciente.apellido, paciente.covid19,consulta.foto_sintomas,consulta.sintomas,especialidad.especialidad,CA.diagnostico, CA.fecha_atencion from medico inner join consulta_atendida CA on medico.id = CA.id_medico inner join consulta on consulta.id = CA.id_consulta inner join paciente on consulta.id_paciente_id = paciente.id inner join especialidad on consulta.id_especialidad_id = especialidad.id where paciente.id = :id;";
        $statement = $em->getConnection()->prepare($queryChida);
        $statement->bindParam(':id', $paciente);
        $statement->execute();
        $consultas = $statement->fetchAll();
        return $consultas;
    }
}