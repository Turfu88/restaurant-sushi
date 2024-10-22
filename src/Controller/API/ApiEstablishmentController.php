<?php

namespace App\Controller\API;

use OpenApi\Attributes as OA;
use App\Services\Establishment\EstablishmentServiceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ApiEstablishmentController extends AbstractController
{
    private EstablishmentServiceHandler $establishmentService;

    public function __construct(EstablishmentServiceHandler $establishmentService)
    {
        $this->establishmentService = $establishmentService;
    }

    #[OA\Get(
        path: '/api/establishments',
        summary: 'Liste tous les établissements',
        tags: ['Establishments'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Retourne la liste des établisements',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'app', type: 'string', example: 'establishment')
                        ]
                    )
                )
            )
        ]
    )]
    #[Route('/establishments', name: 'get_establishment_collection', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $establishments = $this->establishmentService->getAllEstablishments();

        return $this->json($establishments);
    }


    #[OA\Patch(
        path: '/api/establishments/{id}/edit',
        summary: 'Met à jour un establishment existant',
        tags: ['Establishments'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1),
                description: "L'ID de l'établissement à mettre à jour"
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Nouveau nom de l\'établissement'),
                    new OA\Property(property: 'address', type: 'string', example: 'Adresse de l\'établissement'),
                    new OA\Property(property: 'availableSeats', type: 'number', format: 'number', example: 40),
                    new OA\Property(property: 'timeLimitBeforeCancel', type: 'number', format: 'number', example: 40),
                    new OA\Property(property: 'open', type: 'boolean', example: true),
                    new OA\Property(property: 'openingAdvancedBookingDays', type: 'number', format: 'number', example: 5),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Etablissement mis à jour avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'Sushi fancy updated'),
                        new OA\Property(property: 'address', type: 'string', example: '1234 rue du saké'),
                        new OA\Property(property: 'availableSeats', type: 'number', format: 'float', example: 65),
                        new OA\Property(property: 'timeLimitBeforeCancel', type: 'number', format: 'float', example: 65),
                        new OA\Property(property: 'open', type: 'boolean', example: true),
                        new OA\Property(property: 'openingAdvancedBookingDays', type: 'number', format: 'number', example: 5),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Etablissement non trouvé'
            )
        ]
    )]    
    #[Route('/establishments/{id}/edit', name: 'update_establishment_item', methods: ['PATCH'])]
    public function establishmentUpdate(Request $request, int $id): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $establishment = $this->establishmentService->updateEstablishmentItem($id, $content);

        return $this->json(  $establishment);
    }


    #[OA\Get(
        path: '/api/establishments/{id}',
        summary: 'Retourne un établissement spécifique',
        tags: ['Establishments'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1),
                description: "L'ID du établissement à récupérer"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails d\'un établissement',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'app', type: 'string', example: 'establishments')
                    ]
                )
            )
        ]
    )]
    #[Route('/establishments/{id}', name: 'get_establishment_item', methods: ['GET'])]
    public function establishmentItem(int $id): JsonResponse
    {
        $establishment = $this->establishmentService->getEstablishmentItem($id);

        return $this->json($establishment);
    }

    #[OA\Post(
        path: '/api/establishments/new',
        summary: 'Ajoute un nouvel établissement',
        tags: ['Establishments'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Sushi fancy updated'),
                    new OA\Property(property: 'address', type: 'string', example: '1234 rue du saké'),
                    new OA\Property(property: 'availableSeats', type: 'number', format: 'float', example: 65),
                    new OA\Property(property: 'timeLimitBeforeCancel', type: 'number', format: 'float', example: 65),
                    new OA\Property(property: 'open', type: 'boolean', example: true),
                    new OA\Property(property: 'openingAdvancedBookingDays', type: 'number', format: 'number', example: 5),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Etablissement ajouté avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'nom', type: 'string', example: 'Sushi resto'),
                        new OA\Property(property: 'address', type: 'string', example: '123 rue du saké'),
                        new OA\Property(property: 'availableSeats', type: 'number', format: 'float', example: 48),
                        new OA\Property(property: 'timeLimitBeforeCancel', type: 'number', format: 'float', example: 35),
                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                    ]
                )
            )
        ]
    )]
    #[Route('/establishments/new', name: 'create_establishment_item', methods: ['POST'])]
    public function establishmentAdd(Request $request): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $establishment = $this->establishmentService->postEstablishmentItem($content);

        return $this->json( $establishment);
    }
}
