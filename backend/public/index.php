<?php
use App\Infrastructure\Controller\DeveloperController;
use App\Infrastructure\Controller\LevelController;
use App\Infrastructure\Route\Route;

require __DIR__ . '/../vendor/autoload.php';
$URL_BASE = "/api";

$router = new Route();
$router->addRoute('POST', $URL_BASE.'/developer', [new DeveloperController(), 'createDeveloper']);
$router->addRoute('GET', $URL_BASE.'/developer', [new DeveloperController(), 'listDeveloper']);
$router->addRoute('PUT', $URL_BASE.'/developer', [new DeveloperController(), 'updateDeveloper']);
$router->addRoute('DELETE', $URL_BASE.'/developer', [new DeveloperController(), 'deleteDeveloper']);
$router->addRoute('GET', $URL_BASE.'/developer/filter', [new DeveloperController(), 'filterDeveloper']);

$router->addRoute('POST', $URL_BASE.'/level', [new LevelController(), 'createLevel']);
$router->addRoute('GET', $URL_BASE.'/level', [new LevelController(), 'listLevel']);
$router->addRoute('PUT', $URL_BASE.'/level', [new LevelController(), 'updateLevel']);
$router->addRoute('DELETE', $URL_BASE.'/level', [new LevelController(), 'deleteLevel']);
$router->addRoute('GET', $URL_BASE.'/level/filter', [new LevelController(), 'filterLevel']);


$router->handleRequest();
