<?php
use App\Infrastructure\Controller\DeveloperController;
use App\Infrastructure\Controller\LevelController;
use App\Infrastructure\Route\Route;

require __DIR__ . '/../vendor/autoload.php';
$URL_BASE = "/api";

$router = new Route();

$router->addRoute('POST', $URL_BASE.'/desenvolvedores', [new DeveloperController(), 'createDeveloper']);
$router->addRoute('GET', $URL_BASE.'/desenvolvedores', [new DeveloperController(), 'listDeveloper']);
$router->addRoute('PUT', $URL_BASE.'/desenvolvedores', [new DeveloperController(), 'updateDeveloper']);
$router->addRoute('DELETE', $URL_BASE.'/desenvolvedores', [new DeveloperController(), 'deleteDeveloper']);
$router->addRoute('GET', $URL_BASE.'/desenvolvedores/filtro', [new DeveloperController(), 'filterDeveloper']);

$router->addRoute('POST', $URL_BASE.'/niveis', [new LevelController(), 'createLevel']);
$router->addRoute('GET', $URL_BASE.'/niveis', [new LevelController(), 'listLevel']);
$router->addRoute('PUT', $URL_BASE.'/niveis', [new LevelController(), 'updateLevel']);
$router->addRoute('DELETE', $URL_BASE.'/niveis', [new LevelController(), 'deleteLevel']);
$router->addRoute('GET', $URL_BASE.'/niveis/filtro', [new LevelController(), 'filterLevel']);

$router->handleRequest();
