<?php

namespace App\Application\UseCase\Level;

use App\Domain\Repository\DeveloperRepositoryInterface;
use App\Domain\Repository\LevelRepositoryInterface;
use Exception;

class DeleteLevel
{
    private LevelRepositoryInterface $repository;
    private DeveloperRepositoryInterface $developerRepository;

    public function __construct(LevelRepositoryInterface $repository, DeveloperRepositoryInterface $developerRepository)
    {
        $this->repository = $repository;
        $this->developerRepository = $developerRepository;
    }

    public function execute(int $id): bool
    {
        if(is_null($this->repository->findById($id))) {
            http_response_code(400);
            echo json_encode("Nenhum registro encontrado.");
            return false;
        }

        if(!is_null($this->developerRepository->findByNivelDeveloper($id))){
            http_response_code(400);
            echo json_encode("existe desenvolvedor associado ao nivel");
            return false;
        }

        return $this->repository->delete($id);
    }
}