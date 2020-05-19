<?php

namespace App\Entity;

use App\Repository\EstadoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EstadoRepository::class)
 */
class Estado
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Pais::class, inversedBy="estados")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_pais;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity=Municipio::class, mappedBy="id_estado")
     */
    private $municipios;

    /**
     * @ORM\OneToMany(targetEntity=Medico::class, mappedBy="id_estado")
     */
    private $medicos;

    public function __construct()
    {
        $this->municipios = new ArrayCollection();
        $this->medicos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getEstado();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * @return Collection|Municipio[]
     */
    public function getMunicipios(): Collection
    {
        return $this->municipios;
    }

    public function addMunicipio(Municipio $municipio): self
    {
        if (!$this->municipios->contains($municipio)) {
            $this->municipios[] = $municipio;
            $municipio->setIdEstado($this);
        }

        return $this;
    }

    public function removeMunicipio(Municipio $municipio): self
    {
        if ($this->municipios->contains($municipio)) {
            $this->municipios->removeElement($municipio);
            // set the owning side to null (unless already changed)
            if ($municipio->getIdEstado() === $this) {
                $municipio->setIdEstado(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Medico[]
     */
    public function getMedicos(): Collection
    {
        return $this->medicos;
    }

    public function addMedico(Medico $medico): self
    {
        if (!$this->medicos->contains($medico)) {
            $this->medicos[] = $medico;
            $medico->setIdEstado($this);
        }

        return $this;
    }

    public function removeMedico(Medico $medico): self
    {
        if ($this->medicos->contains($medico)) {
            $this->medicos->removeElement($medico);
            // set the owning side to null (unless already changed)
            if ($medico->getIdEstado() === $this) {
                $medico->setIdEstado(null);
            }
        }

        return $this;
    }
}
