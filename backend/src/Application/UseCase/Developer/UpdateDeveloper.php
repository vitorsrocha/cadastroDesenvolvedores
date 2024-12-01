<?php

namespace App\Application\UseCase\Developer;

use App\Application\DTOs\DevelopersDTO;
use App\Domain\Entities\Developer;
use App\Domain\Repository\DeveloperRepositoryInterface;
use App\Domain\Repository\LevelRepositoryInterface;
use DateTimeImmutable;
use Exception;

class UpdateDeveloper
{
    private DeveloperRepositoryInterface $repository;
    private LevelRepositoryInterface $levelRepository;

    public function __construct(DeveloperRepositoryInterface $repository, LevelRepositoryInterface $levelRepository)
    {
        $this->repository = $repository;
        $this->levelRepository = $levelRepository;
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function execute(DevelopersDTO $developerDTO, int $id): Developer
    {
        $level = $this->levelRepository->findById($developerDTO->getNivelId());
        if (empty($level)) {
            http_response_code(400);
            throw new Exception("Nivel inexistente");
        }

        if(is_null($this->repository->findByDeveloper($id))) {
            http_response_code(400);
            throw new Exception('Nenhum registro encontrado');
        }

        if (empty($developerDTO->getNivelId()) || empty($developerDTO->getNome()) || empty($developerDTO->getSexo()) || empty($developerDTO->getDataNascimento()) || empty($developerDTO->getHobby())) {
            http_response_code(400);
            throw new Exception("Todos os campos são obrigatórios");
        }

        return $this->repository->update(new Developer(
            $id,
            $developerDTO->getNivelId(),
            $developerDTO->getNome(),
            $developerDTO->getSexo(),
            new DateTimeImmutable($developerDTO->getDataNascimento()),
            $developerDTO->getHobby()
        ), $id);
    }

}