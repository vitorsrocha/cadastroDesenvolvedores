<?php

namespace App\Application\UseCase\Level;

use App\Domain\Repository\LevelRepositoryInterface;

class FilterLevel
{
    private LevelRepositoryInterface $repository;

    public function __construct(LevelRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $value): array
    {
        return $this->repository->findByLevel($value);
    }
}