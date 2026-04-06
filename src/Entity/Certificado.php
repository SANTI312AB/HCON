<?php

namespace App\Entity;

use App\Repository\CertificadoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CertificadoRepository::class)
 */
class Certificado
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;



    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private  $fecha_inicio;

    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private  $fecha_final;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private ?string $tipo_contingencia = null;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $empresa = null;

    /**
     * @ORM\OneToOne(targetEntity=Consulta::class, inversedBy="certificado")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Consulta $consulta;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
    */
    private ?string $contacto=null;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
    */
    private ?string $telefono=null;

        /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private ?string $licencia = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio(?\DateTimeInterface $fecha_inicio): self
    {
        $this->fecha_inicio = $fecha_inicio;
        return $this;
    }

    public function getFechaFinal(): ?\DateTimeInterface
    {
        return $this->fecha_final;
    }

    public function setFechaFinal(?\DateTimeInterface $fecha_final): self
    {
        $this->fecha_final = $fecha_final;
        return $this;
    }

    public function getTipoContingencia(): ?string
    {
        return $this->tipo_contingencia;
    }

    public function setTipoContingencia(?string $tipo_contingencia): self
    {
        $this->tipo_contingencia = $tipo_contingencia;
        return $this;
    }

    public function getEmpresa(): ?string
    {
         return $this->empresa;
    }

    public function setEmpresa(?string $empresa): self
    {
        $this->empresa = $empresa;
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

    public function getContacto(): ?string
    {
        return $this->contacto;
    }

    public function setContacto(?string $contacto): self
    {
        $this->contacto = $contacto;
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

    public function getLicencia(): ?string
    {
        return $this->licencia;
    }

    public function setLicencia(?string $licencia): self
    {
        $this->licencia = $licencia;
        return $this;
    }


}
