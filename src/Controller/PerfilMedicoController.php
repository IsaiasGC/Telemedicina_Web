<?php

namespace App\Controller;

use App\Entity\Especialidad;
use App\Entity\Medico;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PerfilMedicoController extends AbstractController
{
    /**
     * @Route("/perfil/medico", name="perfil_medico")
     */
    public function index()
    {
        $medicoActual = $this->obtenerDatosMedicoActual();
        $especialidades = $this->obtenerEspecialidades($medicoActual[0]['medico_id']);
        $resultServicios = $this->obtenerServicios($medicoActual[0]['medico_id']);
        $form = $this->formEspecialidad($medicoActual);
        $form2=$this->formServicio($medicoActual);

        $pacientes=$this->obtenerConsultas($medicoActual[0]['medico_id']);
        $pacientes_atendidos=
            $this->obtenerConsultaAtendidas($medicoActual[0]['medico_id']);

        return $this->render('perfil_medico/index.html.twig', [
            'controller_name' => 'PerfilMedicoController',
                'medico'  => $medicoActual,
            'especialidades' => $especialidades,
            'pacientes'=>$pacientes,
            'servicios' => $resultServicios,
            'pacientesAtendidos'=>$pacientes_atendidos,
            'form'=>$form->createView(),
            'form2'=>$form2->createView()
        ]);
    }

    /**
     * @Route("/perfil/medico/agregarEspecialidad", name="agregarEspecialidadMedico", methods={"POST"})
     */
    public function agregarEspecialidad(Request $request)
    {
        $bag =$request->request->get('form');
        $id_especialidad = $bag['idEspecialidad'];

        $id_medico=$request->query->get('id_medico');
        $this->getDoctrine()
            ->getRepository(Medico::class)
            ->agregarEspecialidad($id_especialidad,$id_medico);

        return $this->redirectToRoute('perfil_medico');
    }

    /**
     * @Route("/perfil/medico/agregarServicio", name="agregarEspecialidadServicio", methods={"POST"})
     */
    public function agregarServicio(Request $request)
    {
        $bag =$request->request->get('form');
        $servicio = $bag['servicio'];
        $costo = $bag['costo'];
        $id_medico=$request->query->get('id_medico');
        $em = $this->getDoctrine()->getManager();
        //Tercera query
        $queryServicios = 'insert into servicio_medico (servicio,costo,id_medico) values(:servicio,:costo,:id_medico)';
        $statement = $em->getConnection()->prepare($queryServicios);
        $statement->bindParam(':servicio', $servicio);
        $statement->bindParam(':costo', $costo);
        $statement->bindParam(':id_medico', $id_medico);
        $statement->execute();

        return $this->redirectToRoute('perfil_medico');
    }



    /**
     * @Route("/perfil/medico/diagnosticarConsulta/{id}", name="diagnosticarConsulta", methods={"GET"})
     */
    public function diagnosticar(Request $request)
    {
        $id_consulta = $request->attributes->get('id');
        $medicoActual = $this->obtenerDatosMedicoActual();
        $diagnostico = $request->query->get('diagnostico');
        $em = $this->getDoctrine()->getManager();
        //Tercera query
        $queryServicios = 'insert into consulta_atendida 
            values (:id_consulta,:id_medico,:diagnostico,now());';
        $statement = $em->getConnection()->prepare($queryServicios);
        $statement->bindParam(':id_consulta', $id_consulta);
        $statement->bindParam(':id_medico', $medicoActual[0]['medico_id']);
        $statement->bindParam(':diagnostico', $diagnostico);
        $statement->execute();

        return $this->redirectToRoute('perfil_medico');
    }









    public function obtenerDatosMedicoActual(){
        $em = $this->getDoctrine()->getManager();
        $RAW_QUERY = 'select user.id as user_id, medico.id as medico_id , 
                        user.email,medico.nombre,medico.apellido,medico.cedula,
                        pais.pais,estado.estado,municipio.municipio,medico.direccion,medico.telefono 
                        from medico inner join user on user.id = medico.id_user_id 
                        inner join pais on pais.id = id_pais_id 
                        inner join estado on estado.id = id_estado_id 
                        inner join municipio on municipio.id = id_municipio_id where user.email = :email';
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        // Set parameters
        $userEmail = $this->getUser()->getUsername();
        $statement->bindParam(':email', $userEmail);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    public function obtenerEspecialidades($id_medico){
        //Segunda query
        $em = $this->getDoctrine()->getManager();
        $queryEspecialidad = 'SELECT especialidad.especialidad 
                                FROM especialidad_medico TE 
                                inner join medico on TE.id_medico = medico.id 
                                inner join especialidad on TE.id_especialidad = especialidad.id where medico.id = :id;';
        $statement = $em->getConnection()->prepare($queryEspecialidad);
        $statement->bindParam(':id', $id_medico);
        $statement->execute();
        $resultEspecialidades = $statement->fetchAll();
        $especialidades ="";
        //print_r($resultEspecialidades);
        foreach ($resultEspecialidades as $clave => $valor)
            foreach ($valor as $dato)
                $especialidades .= $dato.', ';
        return $especialidades;
    }

    public function obtenerServicios($id_medico){
        $em = $this->getDoctrine()->getManager();
        //Tercera query
        $queryServicios = 'select SM.servicio , SM.costo from servicio_medico SM 
                                inner join medico on SM.id_medico = medico.id where medico.id = :id;';
        $statement = $em->getConnection()->prepare($queryServicios);
        $statement->bindParam(':id', $id_medico);
        $statement->execute();
        $resultServicios = $statement->fetchAll();
        return $resultServicios;
    }

    public function obtenerConsultas($id_medico){
        $em = $this->getDoctrine()->getManager();
        $queryChida="select paciente.*, consulta.id as id_consulta,consulta.sintomas,consulta.foto_sintomas,especialidad.especialidad 
                     from paciente inner join consulta on paciente.id = consulta.id_paciente_id                      
                     inner join especialidad on especialidad.id = consulta.id_especialidad_id
                    inner join especialidad_medico on especialidad.id = especialidad_medico.id_especialidad
                    inner join medico on especialidad_medico.id_medico = medico.id 
                    where especialidad.id in 
                    ( select especialidad.id from especialidad_medico      
                    inner join medico on especialidad_medico.id_medico=medico.id          
                    inner join especialidad on especialidad_medico.id_especialidad = especialidad.id 
                    where medico.id = :id);";
        $statement = $em->getConnection()->prepare($queryChida);
        $statement->bindParam(':id', $id_medico);
        $statement->execute();
        $consultas = $statement->fetchAll();
        return $consultas;
    }


    public function obtenerConsultaAtendidas($id_medico){
        //select paciente.nombre, paciente.covid19,consulta.sintomas,consulta.foto_sintomas,consulta.sintomas,especialidad.especialidad,CA.diagnostico, CA.fecha_atencion from medico inner join consulta_atendida CA on medico.id = CA.id_medico inner join consulta on consulta.id = CA.id_consulta inner join paciente on consulta.id_paciente_id = paciente.id inner join especialidad on consulta.id_especialidad_id = especialidad.id;
        $em = $this->getDoctrine()->getManager();
        $queryChida="select consulta.id as id_consulta, paciente.nombre, paciente.covid19,consulta.foto_sintomas,consulta.sintomas,especialidad.especialidad,CA.diagnostico, CA.fecha_atencion from medico inner join consulta_atendida CA on medico.id = CA.id_medico inner join consulta on consulta.id = CA.id_consulta inner join paciente on consulta.id_paciente_id = paciente.id inner join especialidad on consulta.id_especialidad_id = especialidad.id where medico.id = :id;";
        $statement = $em->getConnection()->prepare($queryChida);
        $statement->bindParam(':id', $id_medico);
        $statement->execute();
        $consultas = $statement->fetchAll();
        return $consultas;
    }

    public function formEspecialidad($medicoActual){
        $form = $this->createFormBuilder()
            ->add('idEspecialidad', EntityType::class, [
                'class' => Especialidad::class,
                'label'=>'Escoge una especialidad'
            ])
            ->add('Agregar', SubmitType::class,
                array('label' => 'Agregar'))
            ->setAction($this->generateUrl('agregarEspecialidadMedico',
                array('id_medico'=>$medicoActual[0]['medico_id'])))
            ->setMethod('POST')
            ->getForm();
        return $form;
    }

    public function formServicio($medicoActual){
        $form = $this->createFormBuilder()
            ->add('servicio', TextType::class, [
                'label'=>'Introduce el nuevo servicio'
            ])
            ->add('costo', NumberType::class)
            ->add('Agregar', SubmitType::class,
                array('label' => 'Agregar'))
            ->setAction($this->generateUrl('agregarEspecialidadServicio',
                array('id_medico'=>$medicoActual[0]['medico_id'])))
            ->setMethod('POST')
            ->getForm();
        return $form;
    }

    public function formDiagnostico(){
        $form = $this->createFormBuilder()
            ->add('diagnostico', TextareaType::class, [
                'label'=>'Introduce el diagnostico para esta consulta'
            ])
            ->getForm();
        return $form;
    }
}