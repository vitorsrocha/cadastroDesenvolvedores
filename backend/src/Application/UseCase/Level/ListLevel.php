<?php

namespace App\Application\UseCase\Level;

use App\Domain\Repository\LevelRepositoryInterface;

class ListLevel
{
    private LevelRepositoryInterface $repository;

    public function __construct(LevelRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->listAll();
    }

}