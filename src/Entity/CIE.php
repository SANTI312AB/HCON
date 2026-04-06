<?php

namespace App\Entity;

use App\Repository\CIERepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CIERepository::class)
 */
class CIE
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigo_tipo;

    /**
     * @ORM\OneToMany(targetEntity=Diagnostico::class, mappedBy="cie", orphanRemoval=true)
     */
    private $diagnosticos;

    public function __construct()
    {
        $this->diagnosticos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(?string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getCodigoTipo(): ?string
    {
        return $this->codigo_tipo;
    }

    public function setCodigoTipo(?string $codigo_tipo): self
    {
        $this->codigo_tipo = $codigo_tipo;

        return $this;
    }

    /**
     * @return Collection|Diagnostico[]
     */
    public function getDiagnosticos(): Collection
    {
        return $this->diagnosticos;
    }

    public function addDiagnostico(Diagnostico $diagnostico): self
    {
        if (!$this->diagnosticos->contains($diagnostico)) {
            $this->diagnosticos[] = $diagnostico;
            $diagnostico->setCie($this);
        }

        return $this;
    }

    public function removeDiagnostico(Diagnostico $diagnostico): self
    {
        if ($this->diagnosticos->removeElement($diagnostico)) {
            // set the owning side to null (unless already changed)
            if ($diagnostico->getCie() === $this) {
                $diagnostico->setCie(null);
            }
        }

        return $this;
    }
}
