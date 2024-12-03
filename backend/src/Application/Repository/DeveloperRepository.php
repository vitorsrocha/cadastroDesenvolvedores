<?php

namespace App\Application\Repository;

use App\Domain\Entities\Developer;
use App\Domain\Repository\DeveloperRepositoryInterface;
use DateTime;
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
        $stmt = $this->pdo->query('    SELECT 
                                                d.id,
                                                d.nome,
                                                d.sexo,
                                                d.data_nascimento,
                                                d.hobby,
                                                n.id AS nivel_id,
                                                n.nivel
                                            FROM desenvolvedores d
                                            INNER JOIN niveis n ON d.nivel_id = n.id;');
        $developers = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $age = $this->calculateAge($row['data_nascimento']);

            $response = [
                    'id' => $row['id'],
                    'nome' => $row['nome'],
                    'sexo' => $row['sexo'],
                    'data_nascimento' => $row['data_nascimento'],
                    'idade' => $age,
                    'hobby' => $row['hobby'],
                    'nivel' => [
                        'id' => $row['nivel_id'],
                        'nivel' => $row['nivel']
                    ]
                ];

            $developers[] = $response;
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
        $stmt->bindValue(':data_nascimento', $developer->getDataNascimento());
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
        $stmt->bindValue(':data_nascimento', $developer->getDataNascimento());
        $stmt->bindValue(':hobby', $developer->getHobby());
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $developer;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM desenvolvedores WHERE id = :id;');
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

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
            $row['data_nascimento'],
            $row['hobby']);
    }

    public function findByIdDeveloper(int $id): ?Developer
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
            $row['data_nascimento'],
            $row['hobby']
        );
    }

    private function calculateAge(string $dataNascimento): int
    {
        $dataNascimento = new DateTime($dataNascimento);
        $day = new DateTime('today');
        return $dataNascimento->diff($day)->y;
    }


    public function findByDeveloper(string $value): array
    {
        $searchTerm = '%' . $value . '%';
        $stmt = $this->pdo->prepare('
        SELECT 
            d.id,
            d.nome,
            d.sexo,
            d.data_nascimento,
            d.hobby,
            n.id AS nivel_id,
            n.nivel 
        FROM desenvolvedores d
        INNER JOIN niveis n ON d.nivel_id = n.id
        WHERE
            CAST(d.id AS CHAR) LIKE :searchTerm OR
            d.nome LIKE :searchTerm OR
            d.sexo LIKE :searchTerm OR
            d.data_nascimento LIKE :searchTerm OR
            d.hobby LIKE :searchTerm OR
            n.nivel LIKE :searchTerm;
        ');
        $stmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        $developers = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $age = $this->calculateAge($row['data_nascimento']);

            $response = [
                'id' => $row['id'],
                'nome' => $row['nome'],
                'sexo' => $row['sexo'],
                'data_nascimento' => $row['data_nascimento'],
                'idade' => $age,
                'hobby' => $row['hobby'],
                'nivel' => [
                    'id' => $row['nivel_id'],
                    'nivel' => $row['nivel']
                ]
            ];

            $developers[] = $response;
        }

        return $developers;
    }
}