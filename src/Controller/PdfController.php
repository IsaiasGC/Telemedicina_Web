<?php

namespace App\Controller;

use App\Entity\Consulta;
use App\Entity\Medico;
use Knp\Snappy\Pdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PdfController extends AbstractController
{
    /**
     * @Route("/pdf/receta/{llave}/download/{id}/{id_medico}", name="pdf_receta",  methods={"GET"})
     */
    public function receta(String $llave, int $id,int $id_medico)
    {
        $rev=md5('Medilafe_receta_id_').$id;

        if($rev!=$llave.$id){
            $response = new Response();
            $response->setContent('<html><body><h1 align="center">No Permissions!</h1></body></html>');
            $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
            return $response;
        }
        $pdf=new Pdf('/usr/local/bin/wkhtmltopdf');
        $datosConsulta = $this->getDoctrine()->getRepository(Medico::class)
            ->obtenerConsultaAtendida($id_medico,$id);

        $html = $this->renderView('pdf/receta.html.twig', [
            'controller_name' => 'PdfController','datosConsulta'=>$datosConsulta
        ]);

        return new PdfResponse(
            $pdf->getOutputFromHtml($html,
                array(
                    'lowquality' => false,
                    'print-media-type' => true,
                    'encoding' => 'utf-8',
                    // 'page-size' => 'A4',
                    'page-height' =>  400,'page-width' => 200,
                    'outline-depth' => 8,
                    'orientation' => 'Landscape',
                    'title'=> 'Medilife',
                    // 'user-style-sheet'=> '../../public/css/bootstrap.min.css',
                    'header-right'=>'Pag. [page] de [toPage]',
                    'header-font-size'=>7,
                )
            ),'receta.pdf'
        );
    }

    /**
     * @Route("/pdf/prueba/{id_consulta}/{id_medico}", name="pdf_prueba",  methods={"GET"})
     */
    public function prueba(int $id_consulta,int $id_medico)
    {
        $datosConsulta = $this->getDoctrine()->getRepository(Medico::class)
            ->obtenerConsultaAtendida($id_medico,$id_consulta);
        return $this->render('pdf/receta.html.twig', [
            'controller_name' => 'PdfController','datosConsulta'=>$datosConsulta
        ]);
    }
    /**
     * @Route("/mail/prueba/{id_consulta}/{id_medico}", name="mail_prueba",  methods={"GET"})
     */
    public function sendReceta(\Swift_Mailer $mailer,int $id_consulta,int $id_medico){
        $datosConsulta = $this->getDoctrine()->getRepository(Medico::class)
            ->obtenerConsultaAtendida($id_medico,$id_consulta);
        $email = $datosConsulta[0]['email'];
        $message = (new \Swift_Message('Medilife - Consulta Atendida'))
            ->setFrom('15030076@itcelaya.edu.mx')
            ->setTo($email)
            ->setBody(
                $this->renderView('pdf/receta.html.twig',['datosConsulta'=>$datosConsulta]),'text/html'
            )
        ;

            // you can remove the following code if you don't define a text version for your emails
            // ->addPart(
            //     $this->renderView(
            //         // templates/emails/registration.txt.twig
            //         'pdf/receta.html.twig'
            //     ),
            //     'text/plain'
            // )

        $mailer->send($message);

        $response = new Response();
            $response->setContent('<html><body><h1 align="center">Correo enviado!</h1></body></html>');
            $response->setStatusCode(Response::HTTP_OK);
            return $response;
    }
}