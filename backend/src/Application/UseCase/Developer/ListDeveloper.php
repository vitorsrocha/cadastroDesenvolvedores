<?php

namespace App\Application\UseCase\Developer;

use App\Domain\Repository\DeveloperRepositoryInterface;

class ListDeveloper
{
    private DeveloperRepositoryInterface $repository;

    public function __construct(DeveloperRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->listAll();
    }
}