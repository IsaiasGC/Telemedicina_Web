<?php
namespace App\Controller;
use App\Entity\Consulta;
use App\Entity\Especialidad;
use App\Entity\Paciente;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PerfilPacienteController extends AbstractController
{
    /**
     * @Route("/perfil/paciente", name="perfil_paciente")
     */
    public function index()
    {
        $email = $this->getUser()->getUsername();
        $paciente = $this->getDoctrine()
            ->getRepository(Paciente::class)
            ->pacienteActual($email);

        $consultas = $this->getDoctrine()
            ->getRepository(Consulta::class)
            ->consultas($paciente[0]['paciente_id']);

        return $this->render('perfil_paciente/index.html.twig', [
            'controller_name' => 'PerfilPacienteController','paciente' => $paciente
            ,'consultas'=>$consultas,
        ]);
    }
}
