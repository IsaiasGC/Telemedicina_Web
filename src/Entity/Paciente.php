<?php

namespace App\Entity;

use App\Repository\PacienteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PacienteRepository::class)
 */
class Paciente
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
     * @ORM\Column(type="string", length=150)
     */
    private $direccion;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\ManyToOne(targetEntity=Municipio::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_municipio;

    /**
     * @ORM\ManyToOne(targetEntity=Estado::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_estado;

    /**
     * @ORM\ManyToOne(targetEntity=Pais::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_pais;

    /**
     * @ORM\Column(type="text")
     */
    private $alergias;

    /**
     * @ORM\Column(type="text")
     */
    private $enfermedades_cronicas;

    /**
     * @ORM\Column(type="text")
     */
    private $cirugias;

    /**
     * @ORM\Column(type="boolean")
     */
    private $covid19=false;

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

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

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

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

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

    public function getAlergias(): ?string
    {
        return $this->alergias;
    }

    public function setAlergias(string $alergias): self
    {
        $this->alergias = $alergias;

        return $this;
    }

    public function getEnfermedadesCronicas(): ?string
    {
        return $this->enfermedades_cronicas;
    }

    public function setEnfermedadesCronicas(string $enfermedades_cronicas): self
    {
        $this->enfermedades_cronicas = $enfermedades_cronicas;

        return $this;
    }

    public function getCirugias(): ?string
    {
        return $this->cirugias;
    }

    public function setCirugias(string $cirugias): self
    {
        $this->cirugias = $cirugias;

        return $this;
    }

    public function getCovid19(): ?bool
    {
        return $this->covid19 ? true: false;
    }

    public function setCovid19(bool $covid19): self
    {
        $this->covid19 = $covid19;

        return $this;
    }
}
