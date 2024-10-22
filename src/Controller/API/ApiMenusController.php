<?php

namespace App\Controller\API;

use OpenApi\Attributes as OA;
use App\Services\Menus\MenuServiceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ApiMenusController extends AbstractController
{
    private MenuServiceHandler $menuService;

    public function __construct(MenuServiceHandler $menuService)
    {
        $this->menuService = $menuService;
    }

    #[OA\Get(
        path: '/api/menus',
        summary: 'Liste tous les menus',
        tags: ['Menus'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Retourne la liste des menus',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'app', type: 'string', example: 'menus')
                        ]
                    )
                )
            )
        ]
    )]
    #[Route('/menus', name: 'get_menu_collection', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $menus = $this->menuService->getAllMenus();

        return $this->json($menus);
    }

    #[OA\Post(
        path: '/api/menus/{id}/product-toggle',
        summary: 'Ajoute / Retire un produit d\'un menu',
        tags: ['Menus'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'action', type: 'string', example: 'add'),
                    new OA\Property(property: 'productId', type: 'integer', example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Produit ajouté/enlevé avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'title', type: 'string', example: 'Menu 1'),
                        new OA\Property(property: 'description', type: 'string', example: 'Détails du menu'),
                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                    ]
                )
            )
        ]
    )]
    #[Route('/menus/{id}/product-toggle', name: 'toggle_menu_product', methods: ['POST'])]
    public function menuProductToggle(Request $request, int $id): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $menu = $this->menuService->toggleMenuProduct($id, $content);

        return $this->json( $menu);
    }


    #[OA\Patch(
        path: '/api/menus/{id}/edit',
        summary: 'Met à jour un menu existant',
        tags: ['Menus'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1),
                description: "L'ID du menu à mettre à jour"
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'title', type: 'string', example: 'Menu mis à jour'),
                    new OA\Property(property: 'description', type: 'string', example: 'Détails mis à jour')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Menu mis à jour avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'title', type: 'string', example: 'Menu mis à jour'),
                        new OA\Property(property: 'description', type: 'string', example: 'Détails mis à jour')
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Menu non trouvé'
            )
        ]
    )]    
    #[Route('/menus/{id}/edit', name: 'update_menu_item', methods: ['PATCH'])]
    public function menuUpdate(Request $request, int $id): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $menu = $this->menuService->updateMenuItem($id, $content);

        return $this->json( $menu);
    }


    #[OA\Get(
        path: '/api/menus/{id}',
        summary: 'Retourne un menu spécifique',
        tags: ['Menus'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1),
                description: "L'ID du menu à récupérer"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails d\'un menu',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'app', type: 'string', example: 'menus')
                    ]
                )
            )
        ]
    )]
    #[Route('/menus/{id}', name: 'get_menu_item', methods: ['GET'])]
    public function menuItem(int $id): JsonResponse
    {
        $menu = $this->menuService->getMenuItem($id);

        return $this->json($menu);
    }

    #[OA\Post(
        path: '/api/menus/new',
        summary: 'Ajoute un nouveau menu',
        tags: ['Menus'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'title', type: 'string', example: 'Menu 1'),
                    new OA\Property(property: 'description', type: 'string', example: 'Détails du menu')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Menu ajouté avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'title', type: 'string', example: 'Menu 1'),
                        new OA\Property(property: 'description', type: 'string', example: 'Détails du menu'),
                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                    ]
                )
            )
        ]
    )]
    #[Route('/menus/new', name: 'create_menu_item', methods: ['POST'])]
    public function menuAdd(Request $request): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $menu = $this->menuService->postMenuItem($content);

        return $this->json( $menu);
    }
}
