<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AppLogRepository;

/**
 * Entidad para Auditoría y Logs del Sistema
 * * @ORM\Entity(repositoryClass=AppLogRepository::class)
 * @ORM\Table(name="app_logs")
 */
class AppLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Nombre del controlador o clase de la entidad afectada
     * @ORM\Column(type="string", length=255)
     */
    private $controller;

    /**
     * Método HTTP (GET, POST) o Acción de BD (INSERT, UPDATE, DELETE)
     * @ORM\Column(type="string", length=100)
     */
    private $method;

    /**
     * Código de estado de la respuesta (200, 404, 500, etc.)
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * ID del usuario logueado que realizó la acción
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userId;

    /**
     * Nombre de la tabla de la base de datos afectada
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $tableName;

    /**
     * ID del registro creado, actualizado o eliminado en la tabla mencionada
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $recordId;

    /**
     * Fecha y hora exacta del evento
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getController(): ?string
    {
        return $this->controller;
    }

    public function setController(string $controller): self
    {
        $this->controller = $controller;
        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getTableName(): ?string
    {
        return $this->tableName;
    }

    public function setTableName(?string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function getRecordId(): ?string
    {
        return $this->recordId;
    }

    public function setRecordId(?string $recordId): self
    {
        $this->recordId = $recordId;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}