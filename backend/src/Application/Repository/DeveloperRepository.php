<?php

namespace App\Application\Repository;

use App\Application\DTOs\DevelopersDTO;
use App\Domain\Entities\Developer;
use App\Domain\Repository\DeveloperRepositoryInterface;
use DateTimeImmutable;
use PDO;

class DeveloperRepository implements DeveloperRepositoryInterface
{
     private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM desenvolvedores');
        $developers = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $developer = new DevelopersDTO($row['nivel_id'],$row['nome'], $row['sexo'], $row['data_nascimento'], $row['hobby']);
            $developer->setId($row['id']);
            $developers[] = $developer->toArray();
        }
        return $developers;
    }

    public function save(Developer $developer): Developer
    {
        $stmt = $this->pdo->prepare('INSERT INTO desenvolvedores (nivel_id, nome, sexo, data_nascimento, hobby) 
                                           VALUES (:nivel_id, :nome, :sexo, :data_nascimento, :hobby)');
        $stmt->bindValue(':nivel_id', $developer->getNivelId());
        $stmt->bindValue(':nome', $developer->getNome());
        $stmt->bindValue(':sexo', $developer->getSexo());
        $stmt->bindValue(':data_nascimento', $developer->getDataNascimento()->format('Y-m-d'));
        $stmt->bindValue(':hobby', $developer->getHobby());
        $stmt->execute();

        $developer->setId($this->pdo->lastInsertId());
        return $developer;
    }

    public function update(Developer $developer, int $id): Developer
    {
        $stmt = $this->pdo->prepare('UPDATE desenvolvedores
                                           SET nivel_id = :nivel_id, nome = :nome, sexo = :sexo, data_nascimento = :data_nascimento, hobby = :hobby
                                           WHERE id = :id');
        $stmt->bindValue(':nivel_id', $developer->getNivelId());
        $stmt->bindValue(':nome', $developer->getNome());
        $stmt->bindValue(':sexo', $developer->getSexo());
        $stmt->bindValue(':data_nascimento', $developer->getDataNascimento()->format('Y-m-d'));
        $stmt->bindValue(':hobby', $developer->getHobby());
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $developer->setId($id);

        return $developer;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM desenvolvedores WHERE id = :id;');
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function findByNivelDeveloper(int $nivel_id): ?Developer
    {
        $stmt = $this->pdo->prepare('SELECT * FROM desenvolvedores WHERE nivel_id = :nivel_id');
        $stmt->bindValue(':nivel_id', $nivel_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($row)){
            return null;
        }

        return new Developer(
            $row['id'],
            $row['nivel_id'],
            $row['nome'],
            $row['sexo'],
            new DateTimeImmutable($row['data_nascimento']),
            $row['hobby']);
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function findByDeveloper(int $id): ?Developer
    {
        $stmt = $this->pdo->prepare('SELECT * FROM desenvolvedores WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($row)){
            return null;
        }

        return new Developer(
            $row['id'],
            $row['nivel_id'],
            $row['nome'],
            $row['sexo'],
            new DateTimeImmutable($row['data_nascimento']),
            $row['hobby']
        );
    }
}