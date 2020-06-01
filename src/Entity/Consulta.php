<?php

namespace App\Entity;

use App\Repository\ConsultaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConsultaRepository::class)
 */
class Consulta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $sintomas;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fotoSintomas;

    /**
     * @ORM\ManyToOne(targetEntity=Especialidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_especialidad;

    /**
     * @ORM\ManyToOne(targetEntity=Paciente::class, inversedBy="consultas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_paciente;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSintomas(): ?string
    {
        return $this->sintomas;
    }

    public function setSintomas(string $sintomas): self
    {
        $this->sintomas = $sintomas;

        return $this;
    }

    public function getFotoSintomas(): ?string
    {
        return $this->fotoSintomas;
    }

    public function setFotoSintomas(?string $fotoSintomas): self
    {
        $this->fotoSintomas = $fotoSintomas;

        return $this;
    }

    public function getIdEspecialidad(): ?Especialidad
    {
        return $this->id_especialidad;
    }

    public function setIdEspecialidad(?Especialidad $id_especialidad): self
    {
        $this->id_especialidad = $id_especialidad;

        return $this;
    }

    public function getIdPaciente(): ?Paciente
    {
        return $this->id_paciente;
    }

    public function setIdPaciente(?Paciente $id_paciente): self
    {
        $this->id_paciente = $id_paciente;
        return $this;
    }
}
