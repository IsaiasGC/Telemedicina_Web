<?php

namespace App\Controller;

use App\Entity\Consulta;
use App\Entity\Paciente;
use App\Form\ConsultaType;
use App\Repository\ConsultaRepository;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/consulta")
 */
class ConsultaController extends AbstractController
{
    /**
     * @Route("/", name="consulta_index", methods={"GET"})
     */
    public function index(ConsultaRepository $consultaRepository): Response
    {
        return $this->render('consulta/index.html.twig', [
            'consultas' => $consultaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="consulta_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $consultum = new Consulta();
        $form = $this->createForm(ConsultaType::class, $consultum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pacienteDatos = $this->getDoctrine()
                ->getRepository(Paciente::class)
                ->pacienteActual($this->getUser()->getUsername());
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['foto']->getData();
            if($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
                $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFileName) . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $consultum->setFotoSintomas($newFilename);
            }
            $consultum->setIdPaciente($this->getDoctrine()->getRepository(Paciente::class)
            ->findOneBySomeField($pacienteDatos[0]['user_id']));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($consultum);
            $entityManager->flush();
            return $this->redirectToRoute('perfil_paciente');
        }



        return $this->render('consulta/new.html.twig', [
            'consultum' => $consultum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="consulta_show", methods={"GET"})
     */
    public function show(Consulta $consultum): Response
    {
        return $this->render('consulta/show.html.twig', [
            'consultum' => $consultum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="consulta_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Consulta $consultum): Response
    {
        $form = $this->createForm(ConsultaType::class, $consultum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('consulta_index');
        }

        return $this->render('consulta/edit.html.twig', [
            'consultum' => $consultum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="consulta_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Consulta $consultum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consultum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($consultum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('consulta_index');
    }
}
