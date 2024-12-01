<?php

namespace App\Application\UseCase\Level;

use App\Application\DTOs\LevelDTO;
use App\Domain\Entities\Level;
use App\Domain\Repository\LevelRepositoryInterface;
use Exception;

class CreateLevel
{
    private LevelRepositoryInterface $repository;

    public function __construct(LevelRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(LevelDTO $levelDTO): Level
    {
        if (empty($levelDTO->getNivel())) {
            http_response_code(400);
            throw new Exception("Todos os campos são obrigatórios");
        }

        $level = $this->repository->save(new Level(
            null,
            $levelDTO->getNivel())
        );

        return new Level($level->getId(), $level->getNivel());
    }
}