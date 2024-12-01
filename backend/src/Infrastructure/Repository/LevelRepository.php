<?php

namespace App\Infrastructure\Repository;

use App\Application\DTOs\LevelDTO;
use App\Domain\Entities\Level;
use App\Domain\Repository\LevelRepositoryInterface;
use PDO;
class LevelRepository implements LevelRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function save(Level $level): Level
    {
        $stmt = $this->pdo->prepare('INSERT INTO niveis (nivel) 
                                           VALUES (:nivel)');
        $stmt->bindValue(':nivel', $level->getNivel());
        $stmt->execute();
        $level->setId($this->pdo->lastInsertId());
        return $level;
    }

    public function listAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM niveis');
        $levels= [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $level = new LevelDTO($row['nivel']);
            $level->setId($row['id']);
            $levels[] = $level->toArray();
        }

        return $levels;
    }

    public function update(Level $level, int $id): Level
    {
        $stmt = $this->pdo->prepare('UPDATE niveis 
                                           SET nivel = :nivel
                                           WHERE id = :id');
        $stmt->bindValue(':nivel', $level->getNivel());
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $level->setId($id);

        return $level;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM niveis 
                                           WHERE id = :id;');
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function findById(int $id): ?Level
    {
        $stmt = $this->pdo->prepare('SELECT * FROM niveis WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($row)) {
            return new Level($row['id'],
                $row['nivel']
            );
        }

        return null;
    }
}