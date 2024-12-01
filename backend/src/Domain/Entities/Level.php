<?php

namespace App\Domain\Entities;

final class Level
{
    private ?int $id;
    private string $nivel;

    public function __construct(?int $id, string $nivel)
    {
        $this->id = $id;
        $this->nivel = $nivel;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNivel(): string
    {
        return $this->nivel;
    }

    public function setNivel(string $nivel): void
    {
        $this->nivel = $nivel;
    }
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'nivel' => $this->getNivel(),
        ];
    }

}