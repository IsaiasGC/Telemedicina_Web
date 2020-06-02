<?php

namespace App\Controller;

use Knp\Snappy\Pdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PdfController extends AbstractController
{
    /**
     * @Route("/pdf/receta/{llave}/download/{id}", name="pdf_receta",  methods={"GET"})
     */
    public function receta(String $llave, int $id)
    {
        $rev=md5('Medilafe_receta_id_'.$id);
        if($rev!=$llave){
            $response = new Response();
            $response->setContent('<html><body><h1 align="center">No Permissions!</h1></body></html>');
            $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
            return $response;
        }
        $pdf=new Pdf('/usr/local/bin/wkhtmltopdf');
        $html = $this->renderView('pdf/receta.html.twig', [
            'controller_name' => 'PdfController',
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
     * @Route("/pdf/prueba", name="pdf_prueba",  methods={"GET"})
     */
    public function prueba()
    {
        return $this->render('pdf/receta.html.twig', [
            'controller_name' => 'PdfController',
        ]);
    }
    /**
     * @Route("/mail/prueba", name="mail_prueba",  methods={"GET"})
     */
    public function sendReceta(\Swift_Mailer $mailer){
        $message = (new \Swift_Message('Medilife - Receta'))
            ->setFrom('15030094@itcelaya.edu.mx')
            ->setTo('j.isaias.g.c@gmail.com')
            ->setBody(
                $this->renderView('pdf/receta.html.twig'),'text/html'
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
