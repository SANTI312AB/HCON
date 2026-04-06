<?php

namespace App\Entity;

use App\Repository\UnidadesoperativasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UnidadesoperativasRepository::class)
 */
class Unidadesoperativas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=100,  nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=80,nullable=true )
     */
    private $regional;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity=Employed::class, mappedBy="unidadesoperativas")
     */
    private $employed;

    /**
     * @ORM\OneToMany(targetEntity=Pacientes::class, mappedBy="unidades_operativas", orphanRemoval=true)
     */
    private $pacientes;

    public function __construct()
    {
        $this->estado = true;
        $this->employed = new ArrayCollection();
        $this->pacientes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getRegional(): ?string
    {
        return $this->regional;
    }

    public function setRegional(?string $regional): self
    {
        $this->regional = $regional;

        return $this;
    }

    public function getEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(?bool $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * @return Collection|Employed[]
     */
    public function getEmployed(): Collection
    {
        return $this->employed;
    }

    public function addEmployed(Employed $employed): self
    {
        if (!$this->employed->contains($employed)) {
            $this->employed[] = $employed;
            $employed->setUnidadesoperativas($this);
        }

        return $this;
    }

    public function removeEmployed(Employed $employed): self
    {
        if ($this->employed->removeElement($employed)) {
            // set the owning side to null (unless already changed)
            if ($employed->getUnidadesoperativas() === $this) {
                $employed->setUnidadesoperativas(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Pacientes[]
     */
    public function getPacientes(): Collection
    {
        return $this->pacientes;
    }

    public function addPaciente(Pacientes $paciente): self
    {
        if (!$this->pacientes->contains($paciente)) {
            $this->pacientes[] = $paciente;
            $paciente->setUnidadesOperativas($this);
        }

        return $this;
    }

    public function removePaciente(Pacientes $paciente): self
    {
        if ($this->pacientes->removeElement($paciente)) {
            // set the owning side to null (unless already changed)
            if ($paciente->getUnidadesOperativas() === $this) {
                $paciente->setUnidadesOperativas(null);
            }
        }

        return $this;
    }
}
