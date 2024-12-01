<?php

namespace App\Infrastructure\Controller;

use App\Application\DTOs\LevelDTO;
use App\Application\UseCase\Level\CreateLevel;
use App\Application\UseCase\Level\DeleteLevel;
use App\Application\UseCase\Level\ListLevel;
use App\Application\UseCase\Level\UpdateLevel;
use App\Infrastructure\DataBases\DataBaseConnection;
use App\Infrastructure\Repository\DeveloperRepository;
use App\Infrastructure\Repository\LevelRepository;
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
                echo json_encode(['error' => 'Nenhum registro encontrado']);
                return;
            }

            echo json_encode($entity, JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Erro de conexão: ' . $e->getMessage()], JSON_PRETTY_PRINT);
        }
    }

    public function createLevel(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['nivel'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Dados inválidos ou ausentes']);
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
            echo json_encode(['error' => 'Erro ao salvar o nivel: ' . $e->getMessage()], JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
        }

    }

    public function updateLevel(): void
    {
        $id = $_GET['id'] ?? null;
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido']);
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
            echo json_encode(['error' => 'Erro ao atualizar o nivel: ' . $e->getMessage()], JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
        }
    }

    public function deleteLevel(): void
    {
        $id = $_GET['id'] ?? null;
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido']);
            return;
        }

        try {
            $dbConnection = new DataBaseConnection();
            $pdo = $dbConnection->getConnection();
            $levelRepository = new LevelRepository($pdo);
            $developerRepository = new DeveloperRepository($pdo);

            //useCase
            $deleteLevel = new DeleteLevel($levelRepository, $developerRepository);
            $deleteLevel->execute($id);

            http_response_code(204);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Erro ao deletar nivel: ' . $e->getMessage()], JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
        }
    }
}