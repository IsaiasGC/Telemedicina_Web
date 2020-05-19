<?php

namespace App\Entity;

use App\Repository\MedicoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedicoRepository::class)
 */
class Medico
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $apellido;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $cedula;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $direccion;

    /**
     * @ORM\ManyToOne(targetEntity=Municipio::class, inversedBy="medicos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_municipio;

    /**
     * @ORM\ManyToOne(targetEntity=Estado::class, inversedBy="medicos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_estado;

    /**
     * @ORM\ManyToOne(targetEntity=Pais::class, inversedBy="medicos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_pais;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telefono;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    public function __toString()
    {
        return $this->getNombre()+" "+getApellido();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getCedula(): ?string
    {
        return $this->cedula;
    }

    public function setCedula(string $cedula): self
    {
        $this->cedula = $cedula;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getIdMunicipio(): ?Municipio
    {
        return $this->id_municipio;
    }

    public function setIdMunicipio(?Municipio $id_municipio): self
    {
        $this->id_municipio = $id_municipio;

        return $this;
    }

    public function getIdEstado(): ?Estado
    {
        return $this->id_estado;
    }

    public function setIdEstado(?Estado $id_estado): self
    {
        $this->id_estado = $id_estado;

        return $this;
    }

    public function getIdPais(): ?Pais
    {
        return $this->id_pais;
    }

    public function setIdPais(?Pais $id_pais): self
    {
        $this->id_pais = $id_pais;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }
}
