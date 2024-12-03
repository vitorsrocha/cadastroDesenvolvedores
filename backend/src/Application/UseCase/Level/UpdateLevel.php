<?php

namespace App\Application\UseCase\Level;

use App\Application\DTOs\LevelDTO;
use App\Domain\Entities\Level;
use App\Domain\Repository\LevelRepositoryInterface;
use Exception;

class UpdateLevel
{
    private LevelRepositoryInterface $repository;

    public function __construct(LevelRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(LevelDTO $levelDTO, int $id): ?Level
    {
        if(is_null($this->repository->findById($id))) {
            http_response_code(400);
            echo json_encode('Nenhum registro encontrado');
            return null;
        }

        if (empty($levelDTO->getNivel())) {
            http_response_code(400);
            echo json_encode("Todos os campos são obrigatórios");
            return null;
        }

        return $this->repository->update(new Level($id, $levelDTO->getNivel()), $id);
    }
}