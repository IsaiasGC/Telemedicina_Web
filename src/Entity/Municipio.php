<?php

namespace App\Entity;

use App\Repository\MunicipioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MunicipioRepository::class)
 */
class Municipio
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Estado::class, inversedBy="municipios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_estado;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $municipio;

    /**
     * @ORM\OneToMany(targetEntity=Medico::class, mappedBy="id_municipio")
     */
    private $medicos;

    public function __construct()
    {
        $this->medicos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getMunicipio();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMunicipio(): ?string
    {
        return $this->municipio;
    }

    public function setMunicipio(string $municipio): self
    {
        $this->municipio = $municipio;

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
            $medico->setIdMunicipio($this);
        }

        return $this;
    }

    public function removeMedico(Medico $medico): self
    {
        if ($this->medicos->contains($medico)) {
            $this->medicos->removeElement($medico);
            // set the owning side to null (unless already changed)
            if ($medico->getIdMunicipio() === $this) {
                $medico->setIdMunicipio(null);
            }
        }

        return $this;
    }

}
