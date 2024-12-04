<?php

namespace App\Infrastructure\Controller;

/**
 * @OA\Get(
 *     path="/developers",
 *     summary="Lista todos os desenvolvedores",
 *     @OA\Response(
 *         response=200,
 *         description="Lista de desenvolvedores",
 *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Developer"))
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Nenhum registro encontrado"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/developers",
 *     summary="Cria um novo desenvolvedor",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateDeveloperRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Desenvolvedor criado com sucesso",
 *         @OA\JsonContent(ref="#/components/schemas/Developer")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dados inválidos ou ausentes"
 *     )
 * )
 */

/**
 * @OA\Put(
 *     path="/developers/{id}",
 *     summary="Atualiza um desenvolvedor existente",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID do desenvolvedor",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateDeveloperRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Desenvolvedor atualizado",
 *         @OA\JsonContent(ref="#/components/schemas/Developer")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="ID ou dados inválidos"
 *     )
 * )
 */

/**
 * @OA\Delete(
 *     path="/developers/{id}",
 *     summary="Deleta um desenvolvedor",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID do desenvolvedor",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Desenvolvedor deletado com sucesso"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="ID inválido"
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="Developer",
 *     type="object",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="nome", type="string", example="João Silva"),
 *         @OA\Property(property="sexo", type="string", example="Masculino"),
 *         @OA\Property(property="data_nascimento", type="string", format="date", example="1990-01-01"),
 *         @OA\Property(property="idade", type="integer", example=33),
 *         @OA\Property(property="hobby", type="string", example="Programar"),
 *         @OA\Property(
 *             property="nivel",
 *             type="object",
 *             properties={
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="nivel", type="string", example="Pleno")
 *             }
 *         )
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="CreateDeveloperRequest",
 *     type="object",
 *     required={"nivel_id", "nome", "sexo", "data_nascimento", "hobby"},
 *     properties={
 *         @OA\Property(property="nivel_id", type="integer", example=1),
 *         @OA\Property(property="nome", type="string", example="Maria Souza"),
 *         @OA\Property(property="sexo", type="string", example="Feminino"),
 *         @OA\Property(property="data_nascimento", type="string", format="date", example="1995-07-20"),
 *         @OA\Property(property="hobby", type="string", example="Desenhar")
 *     }
 * )
 */