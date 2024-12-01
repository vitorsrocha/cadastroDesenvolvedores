<?php

namespace App\Application\UseCase\Developer;

use App\Domain\Repository\DeveloperRepositoryInterface;
use Exception;

class DeleteDeveloper
{
    private DeveloperRepositoryInterface $repository;

    public function __construct(DeveloperRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        if(is_null($this->repository->findByDeveloper($id))){
            http_response_code(400);
            throw new Exception('Nenhum registro encontrado.');
        }
        return $this->repository->delete($id);
    }
}