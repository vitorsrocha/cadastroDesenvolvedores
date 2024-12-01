<?php

namespace App\Domain\Entities;

use DateTimeInterface;

class Developer
{
    private ?int $id;
    private int $nivel_id;
    private string $nome;
    private string $sexo;
    private DateTimeInterface $data_nascimento;
    private string $hobby;

    /**
     * @param ?int $id
     * @param int $nivel_id
     * @param string $nome
     * @param string $sexo
     * @param DateTimeInterface $data_nascimento
     * @param string $hobby
     */
    public function __construct(?int $id, int $nivel_id, string $nome, string $sexo, DateTimeInterface $data_nascimento, string $hobby)
    {
        $this->id = $id;
        $this->nivel_id = $nivel_id;
        $this->nome = $nome;
        $this->sexo = $sexo;
        $this->data_nascimento = $data_nascimento;
        $this->hobby = $hobby;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNivelId(): int
    {
        return $this->nivel_id;
    }

    public function setNivelId(int $nivel_id): void
    {
        $this->nivel_id = $nivel_id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getSexo(): string
    {
        return $this->sexo;
    }

    public function setSexo(string $sexo): void
    {
        $this->sexo = $sexo;
    }

    public function getDataNascimento(): \DateTimeInterface
    {
        return $this->data_nascimento;
    }

    public function setDataNascimento(\DateTimeInterface $data_nascimento): void
    {
        $this->data_nascimento = $data_nascimento;
    }

    public function getHobby(): string
    {
        return $this->hobby;
    }

    public function setHobby(string $hobby): void
    {
        $this->hobby = $hobby;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nivel_id' => $this->getNivelId(),
            'nome' => $this->getNome(),
            'sexo' => $this->getSexo(),
            'data_nascimento' => $this->getDataNascimento(),
            'hobby' => $this->getHobby()
        ];
    }

}

