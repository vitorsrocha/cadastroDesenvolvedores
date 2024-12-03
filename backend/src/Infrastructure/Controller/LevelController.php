<?php

namespace App\Infrastructure\Controller;

use App\Application\DTOs\LevelDTO;
use App\Application\Repository\DeveloperRepository;
use App\Application\Repository\LevelRepository;
use App\Application\UseCase\Level\CreateLevel;
use App\Application\UseCase\Level\DeleteLevel;
use App\Application\UseCase\Level\FilterLevel;
use App\Application\UseCase\Level\ListLevel;
use App\Application\UseCase\Level\UpdateLevel;
use App\Infrastructure\DataBases\DataBaseConnection;
use Exception;
use PDOException;

class LevelController
{
    public function listLevel(): void
    {
        try {
            $dbConnection = new DataBaseConnection();
            $pdo = $dbConnection->getConnection();
            $levelRepository = new LevelRepository($pdo);

            //useCase
            $listLevel = new ListLevel($levelRepository);
            $entity = $listLevel->execute();

            if(empty($entity)){
                http_response_code(404);
                echo json_encode('Nenhum registro encontrado.');
                return;
            }

            echo json_encode($entity, JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            echo json_encode('Erro de conexão: ' . $e->getMessage());
        } catch (Exception $e){
            echo json_encode( $e->getMessage());
        }
    }

    public function createLevel(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['nivel'])) {
            http_response_code(400);
            echo json_encode('Dados inválidos ou ausentes');
            return;
        }

        try {
            $dbConnection = new DataBaseConnection();
            $pdo = $dbConnection->getConnection();
            $levelRepository = new LevelRepository($pdo);

            //useCase
            $createLevel = new CreateLevel($levelRepository);
            $levelDTO = new LevelDTO($data['nivel']);
            $level = $createLevel->execute($levelDTO);

            http_response_code(201);
            echo json_encode($level->toArray(), JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            echo json_encode('Erro ao salvar o nivel: ' . $e->getMessage());
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }

    }

    public function updateLevel(): void
    {
        $id = $_GET['id'] ?? null;
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode('ID inválido');
            return;
        }
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['nivel'])) {
            http_response_code(400);
            echo json_encode($data, JSON_PRETTY_PRINT);
            return;
        }

        try {
            $dbConnection = new DataBaseConnection();
            $pdo = $dbConnection->getConnection();
            $levelRepository = new LevelRepository($pdo);

            //useCase
            $updateLevel = new UpdateLevel($levelRepository);
            $levelDTO = new LevelDTO($data['nivel']);
            $level = $updateLevel->execute($levelDTO, $id);

            echo json_encode($level->toArray(), JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            echo json_encode('Erro ao atualizar nivel: ' . $e->getMessage());
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
    }

    public function deleteLevel(): void
    {
        $id = $_GET['id'] ?? null;
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode('ID inválido');
            return;
        }

        try {
            $dbConnection = new DataBaseConnection();
            $pdo = $dbConnection->getConnection();
            $levelRepository = new LevelRepository($pdo);
            $developerRepository = new DeveloperRepository($pdo);

            //useCase
            $deleteLevel = new DeleteLevel($levelRepository, $developerRepository);

            if($deleteLevel->execute($id))
                http_response_code(204);

        } catch (PDOException $e) {
            echo json_encode('Erro ao deletar nivel: ' . $e->getMessage());
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
    }

    public function filterLevel(): void{
        $value = $_GET['value'] ?? null;
        if (empty($value)) {
            http_response_code(400);
            echo json_encode(['message' => 'Valor inválido']);
            return;
        }

        try {
            $dbConnection = new DataBaseConnection();
            $pdo = $dbConnection->getConnection();
            $levelRepository = new LevelRepository($pdo);

            //useCase
            $filterLevel = new FilterLevel($levelRepository);
            $entity = $filterLevel->execute($value);
            echo json_encode($entity, JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            echo json_encode('Erro ao filtrar level: ' . $e->getMessage());
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
    }
}