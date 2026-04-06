<?php

namespace App\Entity;

use App\Repository\DiagnosticoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiagnosticoRepository::class)
 */
class Diagnostico
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $tipo_diagnostico;

  
    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $solicitud;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $procedimiento;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $interconsulta;

    /**
     * @ORM\ManyToOne(targetEntity=Pacientes::class, inversedBy="diagnosticos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pacientes;

    /**
     * @ORM\ManyToOne(targetEntity=CIE::class, inversedBy="diagnosticos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cie;

    /**
     * @ORM\OneToMany(targetEntity=Tratamiento::class, mappedBy="diagnostico",orphanRemoval=true )
     */
    private $tratamiento;

    /**
     * @ORM\ManyToOne(targetEntity=Consulta::class, inversedBy="diagnosticos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $consulta;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $solicitud_complementaria;

    public function __construct()
    {
        $this->tratamiento = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDignostico(): ?string
    {
        return $this->dignostico;
    }

    public function setDignostico(?string $dignostico): self
    {
        $this->dignostico = strtoupper ($dignostico);

        return $this;
    }

    public function getTipoDiagnostico(): ?string
    {
        return $this->tipo_diagnostico;
    }

    public function setTipoDiagnostico(?string $tipo_diagnostico): self
    {
        $this->tipo_diagnostico = strtoupper ($tipo_diagnostico);

        return $this;
    }


    public function getSolicitud(): ?string
    {
        return $this->solicitud;
    }

    public function setSolicitud(?string $solicitud): self
    {
        $this->solicitud = strtoupper($solicitud);

        return $this;
    }

    public function getProcedimiento(): ?string
    {
        return $this->procedimiento;
    }

    public function setProcedimiento(?string $procedimiento): self
    {
        $this->procedimiento = strtoupper($procedimiento);

        return $this;
    }

    public function getInterconsulta(): ?string
    {
        return $this->interconsulta;
    }

    public function setInterconsulta(?string $interconsulta): self
    {
        $this->interconsulta = strtoupper($interconsulta);

        return $this;
    }

    public function getPacientes(): ?Pacientes
    {
        return $this->pacientes;
    }

    public function setPacientes(?Pacientes $pacientes): self
    {
        $this->pacientes = $pacientes;

        return $this;
    }

    public function getCie(): ?CIE
    {
        return $this->cie;
    }

    public function setCie(?CIE $cie): self
    {
        $this->cie = $cie;

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

    public function getSolicitudComplementaria(): ?string
    {
        return $this->solicitud_complementaria;
    }

    public function setSolicitudComplementaria(?string $solicitud_complementaria): self
    {
        $this->solicitud_complementaria = strtoupper($solicitud_complementaria);

        return $this;
    }

    /**
     * @return Collection|Tratamiento[]
     */
    public function getTratamiento(): Collection
    {
        return $this->tratamiento;
    }

    public function addTratamiento(Tratamiento $tratamiento): self
    {
        if (!$this->tratamiento->contains($tratamiento)) {
            $this->tratamiento[] = $tratamiento;
            $tratamiento->setDiagnostico($this);
        }

        return $this;
    }

    public function removeTratamiento(Tratamiento $tratamiento): self
    {
        if ($this->tratamiento->removeElement($tratamiento)) {
            // set the owning side to null (unless already changed)
            if ($tratamiento->getDiagnostico() === $this) {
                $tratamiento->setDiagnostico(null);
            }
        }

        return $this;
    }
}
