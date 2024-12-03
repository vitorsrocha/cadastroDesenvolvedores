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
        if(is_null($this->repository->findByIdDeveloper($id))){
            http_response_code(400);
            echo json_encode('Nenhum registro encontrado.');
            return false;
        }
        return $this->repository->delete($id);
    }
}