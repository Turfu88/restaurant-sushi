<?php

namespace App\Controller\API;

use OpenApi\Attributes as OA;
use App\Services\StaffMembers\StaffMemberServiceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ApiStaffMembersController extends AbstractController
{
    private StaffMemberServiceHandler $staffMemberService;

    public function __construct(StaffMemberServiceHandler $staffMemberService)
    {
        $this->staffMemberService = $staffMemberService;
    }

    #[OA\Get(
        path: '/api/staff-members',
        summary: 'Liste tous les employés',
        tags: ['StaffMembers'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Retourne la liste des employés',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'app', type: 'string', example: 'staffMembers')
                        ]
                    )
                )
            )
        ]
    )]
    #[Route('/staff-members', name: 'get_staff_member_collection', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $staffMembers = $this->staffMemberService->getAllStaffMembers();

        return $this->json($staffMembers);
    }

    #[OA\Post(
        path: '/api/staff-members/{id}/establishment-toggle',
        summary: 'Ajoute / Retire un établissement d\'un employé',
        tags: ['StaffMembers'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'action', type: 'string', example: 'add'),
                    new OA\Property(property: 'establishmentId', type: 'integer', example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Etablissement ajouté/enlevé avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'firstname', type: 'string', example: 'Joe'),
                        new OA\Property(property: 'lastname', type: 'string', example: 'Hills'),
                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                    ]
                )
            )
        ]
    )]
    #[Route('/staff-members/{id}/establishment-toggle', name: 'toggle_staff_member_establishment', methods: ['POST'])]
    public function staffMemberEstablishmentToggle(Request $request, int $id): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $staffMember = $this->staffMemberService->toggleStaffMemberEstablishment($id, $content);

        return $this->json( $staffMember);
    }



    #[OA\Patch(
        path: '/api/staff-members/{id}/edit',
        summary: 'Met à jour un employé existant',
        tags: ['StaffMembers'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1),
                description: "L'ID du employé à mettre à jour"
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'firstname', type: 'string', example: 'Joe'),
                    new OA\Property(property: 'lastname', type: 'string', example: 'Larsen'),
                    new OA\Property(property: 'role', type: 'string', example: 'Serveur'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Informations employé mis à jour avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'firstname', type: 'string', example: 'Joe'),
                        new OA\Property(property: 'lastname', type: 'string', example: 'Larsen'),
                        new OA\Property(property: 'role', type: 'string', example: 'serveur'),
                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2024-10-14T12:00:00Z'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Employé non trouvé'
            )
        ]
    )]    
    #[Route('/staff-members/{id}/edit', name: 'update_staff_member_item', methods: ['PATCH'])]
    public function staffMemberUpdate(Request $request, int $id): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $staffMember = $this->staffMemberService->updateStaffMemberItem($id, $content);

        return $this->json( $staffMember);
    }


    #[OA\Get(
        path: '/api/staff-members/{id}',
        summary: 'Retourne un employé spécifique',
        tags: ['StaffMembers'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1),
                description: "L'ID de l'employé à récupérer"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails d\'un employé',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'app', type: 'string', example: 'staffMembers')
                    ]
                )
            )
        ]
    )]
    #[Route('/staff-members/{id}', name: 'get_staff_member_item', methods: ['GET'])]
    public function staffMemberItem(int $id): JsonResponse
    {
        $staffMember = $this->staffMemberService->getStaffMemberItem($id);

        return $this->json($staffMember);
    }

    #[OA\Post(
        path: '/api/staff-members/new',
        summary: 'Ajoute un nouvel employé. Créé un nouvel utilisateur.',
        tags: ['StaffMembers'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'firstname', type: 'string', example: 'Joe'),
                    new OA\Property(property: 'lastname', type: 'string', example: 'Hills'),
                    new OA\Property(property: 'role', type: 'string', example: 'Cuisinier'),
                    new OA\Property(property: 'username', type: 'string', example: '987987'),
                    new OA\Property(property: 'password', type: 'string', example: 'azerty'),
                    ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Employé ajouté avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'firstname', type: 'string', example: 'Joe'),
                        new OA\Property(property: 'lastname', type: 'string', example: 'Hills'),
                        new OA\Property(property: 'role', type: 'string', example: 'Cuisinier'),
                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                    ]
                )
            )
        ]
    )]
    #[Route('/staff-members/new', name: 'create_staff_member_item', methods: ['POST'])]
    public function staffMemberAdd(Request $request): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $staffMember = $this->staffMemberService->postStaffMemberItem($content);

        return $this->json($staffMember);
    }
}
