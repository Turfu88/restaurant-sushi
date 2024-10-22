<?php

namespace App\Controller\API;

use OpenApi\Attributes as OA;
use App\Services\Bookings\BookingServiceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ApiBookingsController extends AbstractController
{
    private BookingServiceHandler $bookingService;

    public function __construct(BookingServiceHandler $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    #[OA\Get(
        path: '/api/bookings',
        summary: 'Liste tous les bookings',
        tags: ['Bookings'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Retourne la liste des réservations',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'name', type: 'string', example: 'CLEMENT')
                        ]
                    )
                )
            )
        ]
    )]
    #[Route('/bookings', name: 'get_booking_collection', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $bookings = $this->bookingService->getAllBookings();

        return $this->json($bookings);
    }

    #[OA\Patch(
        path: '/api/bookings/{id}/edit',
        summary: 'Met à jour une réservation existante',
        tags: ['Bookings'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1),
                description: "L'ID de la réservation à mettre à jour"
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'CLEMENT'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Réservation mise à jour avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'CLEMENT'),
                        new OA\Property(property: 'description', type: 'string', example: 'Détails mis à jour')
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Réservation non trouvée'
            )
        ]
    )]    
    #[Route('/bookings/{id}/edit', name: 'update_booking_item', methods: ['PATCH'])]
    public function bookingUpdate(Request $request, int $id): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $booking = $this->bookingService->updateBookingItem($id, $content);

        return $this->json( $booking);
    }


    #[OA\Get(
        path: '/api/bookings/{id}',
        summary: 'Retourne un booking spécifique',
        tags: ['Bookings'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1),
                description: "L'ID du booking à récupérer"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails d\'un booking',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'app', type: 'string', example: 'bookings')
                    ]
                )
            )
        ]
    )]
    #[Route('/bookings/{id}', name: 'get_booking_item', methods: ['GET'])]
    public function bookingItem(int $id): JsonResponse
    {
        $booking = $this->bookingService->getBookingItem($id);

        return $this->json($booking);
    }

    #[OA\Post(
        path: '/api/bookings/new',
        summary: 'Ajoute une nouvelle réservation',
        tags: ['Bookings'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'CLEMENT'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Réservation créée avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'CLEMENT'),
                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                    ]
                )
            )
        ]
    )]
    #[Route('/bookings/new', name: 'create_booking_item', methods: ['POST'])]
    public function bookingAdd(Request $request): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $booking = $this->bookingService->postBookingItem($content);

        return $this->json( $booking);
    }
}
