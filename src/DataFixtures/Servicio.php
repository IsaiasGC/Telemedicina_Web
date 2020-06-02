<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Servicio extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->createServicios($manager);
    }

    private function createServicios(ObjectManager $manager)
    {
        $servicio = new \App\Entity\Servicio();
        $servicio->setServicio("Atención a las enfermedades propias de los adolescentes");
        $manager->persist($servicio);
        $manager->flush();
        $servicio->setServicio("Charlas sobre salud sexual reproductiva en adolescentes");
        $manager->persist($servicio);
        $manager->flush();
        $servicio->setServicio("Atención a enfermedades crónicas no transmisibles");
        $manager->persist($servicio);
        $manager->flush();
        $servicio->setServicio("Atención a enfermedades infecciosas");
        $manager->persist($servicio);
        $manager->flush();
        $servicio->setServicio("Valoración de exámenes especiales");
        $manager->persist($servicio);
        $manager->flush();
        $servicio->setServicio("Inyectables");
        $manager->persist($servicio);
        $manager->flush();
        $servicio->setServicio("Prueba de medición de azúcar en sangre");
        $manager->persist($servicio);
        $manager->flush();
        $servicio->setServicio("Consejería en estilos de vida saludable");
        $manager->persist($servicio);
        $manager->flush();
        $servicio->setServicio("Atención del embarazo de riesgo");
        $manager->persist($servicio);
        $manager->flush();
    }
}
