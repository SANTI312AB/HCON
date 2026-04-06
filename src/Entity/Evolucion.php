<?php

namespace App\Entity;

use App\Repository\EvolucionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvolucionRepository::class)
 */
class Evolucion
{
     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=300,nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity=Consulta::class, inversedBy="evoluciones")
     * @ORM\JoinColumn(nullable=true)
     */
    private $consulta;

     /**
     * @ORM\ManyToOne(targetEntity=Pacientes::class, inversedBy="evoluciones")
     * @ORM\JoinColumn(nullable=true)
     */
    private $paciente;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getConsulta(): ?Consulta
    {
        return $this->consulta;
    }

    public function setConsulta(?Consulta $consulta): self
    {
        $this->consulta = $consulta;

        return $this;
    }

    public function getPaciente(): ?Pacientes
    {
        return $this->paciente;
    }

    public function setPaciente(?Pacientes $paciente): self
    {
        $this->paciente = $paciente;

        return $this;
    }
}
