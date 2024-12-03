<?php

namespace App\Domain\Repository;

use App\Domain\Entities\Level;

interface LevelRepositoryInterface
{
    public function listAll(): array;
    public function save(Level $level): Level;
    public function update(Level $level, int $id): Level;
    public function delete(int $id): bool;
    public function findById(int $id): ?Level;
    public function findByLevel(string $value): array;


}