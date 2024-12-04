<?php

namespace App\Infrastructure\Controller;

use App\Application\DTOs\DevelopersDTO;
use App\Application\Repository\DeveloperRepository;
use App\Application\Repository\LevelRepository;
use App\Application\UseCase\Developer\CreateDeveloper;
use App\Application\UseCase\Developer\DeleteDeveloper;
use App\Application\UseCase\Developer\FilterDeveloper;
use App\Application\UseCase\Developer\ListDeveloper;
use App\Application\UseCase\Developer\UpdateDeveloper;
use App\Infrastructure\DataBases\DataBaseConnection;
use Exception;
use PDOException;


class DeveloperController
{

    public function listDeveloper(): void
    {
        try {
            $dbConnection = new DataBaseConnection();
            $pdo = $dbConnection->getConnection();
            $developerRepository = new DeveloperRepository($pdo);

            //useCase
            $listDevelopers = new ListDeveloper($developerRepository);

            $entity = $listDevelopers->execute();

            if(empty($entity)){
                http_response_code(404);
                echo json_encode('Nenhum registro encontrado');
                return;
            }

            echo json_encode($entity, JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            echo json_encode('Erro de conexão: ' . $e->getMessage());
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
    }

    public function createDeveloper(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['nivel_id']) || empty($data['nome']) || empty($data['sexo']) || empty($data['data_nascimento']) || empty($data['hobby'])) {
            http_response_code(400);
            echo json_encode('Dados inválidos ou ausentes');
            return;
        }

        try {
            $dbConnection = new DataBaseConnection();
            $pdo = $dbConnection->getConnection();
            $developerRepository = new DeveloperRepository($pdo);
            $levelRepository = new LevelRepository($pdo);

            //useCase
            $createDevelopers = new CreateDeveloper($developerRepository, $levelRepository);
            $developersDTO = new DevelopersDTO(
                $data['nivel_id'],
                $data['nome'],
                $data['sexo'],
                $data['data_nascimento'],
                $data['hobby']
            );

            $developer = $createDevelopers->execute($developersDTO);

            http_response_code(201);
            echo json_encode($developer->toArray(), JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            echo json_encode('Erro ao salvar o desenvolvedor: ' . $e->getMessage());
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
    }

    public function updateDeveloper(): void
    {
        $id = $_GET['id'] ?? null;
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode('ID inválido');
            return;
        }
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['nivel_id']) || empty($data['nome']) || empty($data['sexo']) || empty($data['data_nascimento']) || empty($data['hobby'])) {
            http_response_code(400);
            echo json_encode($data);
            return;
        }

        try {
            $dbConnection = new DataBaseConnection();
            $pdo = $dbConnection->getConnection();
            $developerRepository = new DeveloperRepository($pdo);
            $levelRepository = new LevelRepository($pdo);

            //useCase
            $updateDevelopers = new UpdateDeveloper($developerRepository, $levelRepository);
            $developersDTO = new DevelopersDTO(
                $data['nivel_id'],
                $data['nome'],
                $data['sexo'],
                $data['data_nascimento'],
                $data['hobby']
            );
            $developersDTO->setId($id);
            $developerDTOResponse = $updateDevelopers->execute($developersDTO, $id);

            if(!is_null($developerDTOResponse))
                echo json_encode($developerDTOResponse->toArray(), JSON_PRETTY_PRINT);

        } catch (PDOException $e) {
            echo json_encode('Erro ao atualizar desenvolvedor: ' . $e->getMessage());
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
    }

    public function deleteDeveloper(): void
    {
        $id = $_GET['id'] ?? null;
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['message' => 'ID inválido']);
            return;
        }

        try {
            $dbConnection = new DataBaseConnection();
            $pdo = $dbConnection->getConnection();
            $developerRepository = new DeveloperRepository($pdo);

            //useCase
            $deleteLevel = new DeleteDeveloper($developerRepository);
            if($deleteLevel->execute($id))
                http_response_code(204);

        } catch (PDOException $e) {
            echo json_encode('Erro ao deletar desenvolvedor: ' . $e->getMessage());
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
    }

    public function filterDeveloper(): void{
        $value = $_GET['valor'] ?? null;
        if (empty($value)) {
            http_response_code(400);
            echo json_encode(['message' => 'Valor inválido']);
            return;
        }

        try {
            $dbConnection = new DataBaseConnection();
            $pdo = $dbConnection->getConnection();
            $developerRepository = new DeveloperRepository($pdo);

            //useCase
            $filterLevel = new FilterDeveloper($developerRepository);
            $entity = $filterLevel->execute($value);
            echo json_encode($entity, JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            echo json_encode('Erro ao filtrar desenvolvedor: ' . $e->getMessage());
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
    }

}