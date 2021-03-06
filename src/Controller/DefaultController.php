<?php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class DefaultController extends AbstractController
    {

        /**
         * @Route("/")
         */
        public function index()
        {
            return $this->render('home/index.html.twig');
        }
    }