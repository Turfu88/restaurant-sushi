<?php

namespace App\Controller\API;

use OpenApi\Attributes as OA;
use App\Services\MealTimes\MealTimeServiceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ApiMealTimesController extends AbstractController
{
    private MealTimeServiceHandler $mealTimeService;

    public function __construct(MealTimeServiceHandler $mealTimeService)
    {
        $this->mealTimeService = $mealTimeService;
    }

    #[OA\Get(
        path: '/api/meal-times',
        summary: 'Liste tous les services',
        tags: ['MealTimes'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Retourne la liste des services',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'date', type: 'string', format: 'date-time', example: '2024-10-22T12:00:00Z'),
                            new OA\Property(property: 'service', type: 'string', example: 'midi'),
                            new OA\Property(property: 'isOpen', type: 'boolean', example: true),
                        ]
                    )
                )
            )
        ]
    )]
    #[Route('/meal-times', name: 'get_meal_time_collection', methods: ['GET'])]
    public function mealTimesCollection(): JsonResponse
    {
        $mealTimes = $this->mealTimeService->getAllMealTimes();

        return $this->json($mealTimes);
    }

    #[OA\Get(
        path: '/api/meal-times/upcoming',
        summary: 'Liste des services à venir',
        tags: ['MealTimes'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Retourne la liste des services à venir. De maintenant jusqu\'à la date limite définie par l\'établissement.',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'date', type: 'string', format: 'date-time', example: '2024-10-22T12:00:00Z'),
                            new OA\Property(property: 'service', type: 'string', example: 'midi'),
                            new OA\Property(property: 'isOpen', type: 'boolean', example: true),
                        ]
                    )
                )
            )
        ]
    )]
    #[Route('/meal-times/upcoming', name: 'get_upcoming_meal_time_collection', methods: ['GET'])]
    public function getUpcomingMealTimesCollection(): JsonResponse
    {
        $mealTimes = $this->mealTimeService->getUpcomingMealTimes();

        return $this->json($mealTimes);
    }


    #[OA\Patch(
        path: '/api/meal-times/{id}/edit',
        summary: 'Met à jour un service existant',
        tags: ['MealTimes'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1),
                description: "L'ID du mealTime à mettre à jour"
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'date', type: 'string', format: 'date-time', example: '2024-10-22T12:00:00Z'),
                    new OA\Property(property: 'service', type: 'string', example: 'midi'),
                    new OA\Property(property: 'isOpen', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'MealTime mis à jour avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'date', type: 'string', format: 'date-time', example: '2024-10-22T12:00:00Z'),
                        new OA\Property(property: 'isOpen', type: 'boolean', example: true),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'MealTime non trouvé'
            )
        ]
    )]    
    #[Route('/meal-times/{id}/edit', name: 'update_meal_time_item', methods: ['PATCH'])]
    public function mealTimeUpdate(Request $request, int $id): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $mealTime = $this->mealTimeService->updateMealTimeItem($id, $content);

        return $this->json( $mealTime);
    }


    #[OA\Get(
        path: '/api/meal-times/{id}',
        summary: 'Retourne un mealTime spécifique',
        tags: ['MealTimes'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1),
                description: "L'ID du mealTime à récupérer"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails d\'un mealTime',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'date', type: 'string', format: 'date-time', example: '2024-10-22T12:00:00Z'),
                        new OA\Property(property: 'isOpen', type: 'boolean', example: true),
                    ]
                )
            )
        ]
    )]
    #[Route('/meal-times/{id}', name: 'get_meal_time_item', methods: ['GET'])]
    public function mealTimeItem(int $id): JsonResponse
    {
        $mealTime = $this->mealTimeService->getMealTimeItem($id);

        return $this->json($mealTime);
    }

    #[OA\Post(
        path: '/api/meal-times/new',
        summary: 'Ajoute un nouveau service',
        tags: ['MealTimes'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'id', type: 'integer', example: 1),
                    new OA\Property(property: 'date', type: 'string', format: 'date-time', example: '2024-10-22T12:00:00Z'),
                    new OA\Property(property: 'isOpen', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Service ajouté avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'date', type: 'string', format: 'date-time', example: '2024-10-22T12:00:00Z'),
                        new OA\Property(property: 'isOpen', type: 'boolean', example: true),
                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                    ]
                )
            )
        ]
    )]
    #[Route('/meal-times/new', name: 'create_meal_time_item', methods: ['POST'])]
    public function mealTimeAdd(Request $request): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $mealTime = $this->mealTimeService->postMealTimeItem($content);

        return $this->json($mealTime);
    }
}
