<?php

namespace App\Entity;

use App\Repository\PaisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaisRepository::class)
 */
class Pais
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
    private $pais;

    /**
     * @ORM\OneToMany(targetEntity=Estado::class, mappedBy="id_pais")
     */
    private $estados;

    /**
     * @ORM\OneToMany(targetEntity=Medico::class, mappedBy="id_pais")
     */
    private $medicos;

    public function __construct()
    {
        $this->estados = new ArrayCollection();
        $this->medicos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getPais();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(string $pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * @return Collection|Estado[]
     */
    public function getEstados(): Collection
    {
        return $this->estados;
    }

    public function addEstado(Estado $estado): self
    {
        if (!$this->estados->contains($estado)) {
            $this->estados[] = $estado;
            $estado->setIdPais($this);
        }

        return $this;
    }

    public function removeEstado(Estado $estado): self
    {
        if ($this->estados->contains($estado)) {
            $this->estados->removeElement($estado);
            // set the owning side to null (unless already changed)
            if ($estado->getIdPais() === $this) {
                $estado->setIdPais(null);
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
            $medico->setIdPais($this);
        }

        return $this;
    }

    public function removeMedico(Medico $medico): self
    {
        if ($this->medicos->contains($medico)) {
            $this->medicos->removeElement($medico);
            // set the owning side to null (unless already changed)
            if ($medico->getIdPais() === $this) {
                $medico->setIdPais(null);
            }
        }

        return $this;
    }
}
