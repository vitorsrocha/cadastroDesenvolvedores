<?php

namespace App\Application\UseCase\Developer;

use App\Application\DTOs\DevelopersDTO;
use App\Domain\Entities\Developer;
use App\Domain\Repository\DeveloperRepositoryInterface;
use App\Domain\Repository\LevelRepositoryInterface;
use DateTimeImmutable;
use Exception;
class CreateDeveloper
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
    public function execute(DevelopersDTO $developerDTO): Developer
    {
        $level = $this->levelRepository->findById($developerDTO->getNivelId());
        if ($level === null) {
            throw new Exception("Level not found");
        }

        if (empty($developerDTO->getNivelId()) || empty($developerDTO->getNome()) || empty($developerDTO->getSexo()) || empty($developerDTO->getDataNascimento()) || empty($developerDTO->getHobby())) {
            http_response_code(400);
            throw new Exception("Todos os campos são obrigatórios");
        }

        return $this->repository->save(new Developer(
            null,
            $developerDTO->getNivelId(),
            $developerDTO->getNome(),
            $developerDTO->getSexo(),
            new DateTimeImmutable($developerDTO->getDataNascimento()),
            $developerDTO->getHobby()));

    }
}