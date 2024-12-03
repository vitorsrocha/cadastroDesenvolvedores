<?php

namespace App\Domain\Repository;

use App\Domain\Entities\Developer;

interface DeveloperRepositoryInterface
{
    public function listAll(): array;
    public function save(Developer $developer): Developer;
    public function update(Developer $developer, int $id): Developer;
    public function delete(int $id): bool;
    public function findByNivelDeveloper(int $id): ?Developer;
    public function findByIdDeveloper(int $id): ?Developer;
    public function findByDeveloper(string $value): array;

}