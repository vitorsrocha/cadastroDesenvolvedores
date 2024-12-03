<?php

namespace App\Application\UseCase\Developer;

use App\Domain\Repository\DeveloperRepositoryInterface;

class FilterDeveloper
{
    private DeveloperRepositoryInterface $repository;

    public function __construct(DeveloperRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $value): array
    {
        return $this->repository->findByDeveloper($value);
    }
}