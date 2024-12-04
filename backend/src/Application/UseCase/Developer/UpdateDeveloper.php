<?php

namespace App\Application\UseCase\Developer;

use App\Application\DTOs\DevelopersDTO;
use App\Domain\Entities\Developer;
use App\Domain\Repository\DeveloperRepositoryInterface;
use App\Domain\Repository\LevelRepositoryInterface;

class UpdateDeveloper
{
    private DeveloperRepositoryInterface $repository;
    private LevelRepositoryInterface $levelRepository;

    public function __construct(DeveloperRepositoryInterface $repository, LevelRepositoryInterface $levelRepository)
    {
        $this->repository = $repository;
        $this->levelRepository = $levelRepository;
    }

    public function execute(DevelopersDTO $developerDTO, int $id): ?Developer
    {
        $level = $this->levelRepository->findById($developerDTO->getNivelId());
        if (empty($level)) {
            http_response_code(400);
            echo json_encode("Nivel inexistente");
            return null;
        }

        if(is_null($this->repository->findByIdDeveloper($id))) {
            http_response_code(400);
            echo json_encode('Nenhum registro encontrado');
            return null;
        }

        if (empty($developerDTO->getNivelId()) || empty($developerDTO->getNome()) || empty($developerDTO->getSexo()) || empty($developerDTO->getDataNascimento()) || empty($developerDTO->getHobby())) {
            http_response_code(400);
            echo json_encode("Todos os campos são obrigatórios");
            return null;
        }

        return $this->repository->update(new Developer(
            $id,
            $developerDTO->getNivelId(),
            $developerDTO->getNome(),
            $developerDTO->getSexo(),
            $developerDTO->getDataNascimento(),
            $developerDTO->getHobby()
        ), $id);
    }

}