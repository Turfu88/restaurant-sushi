<?php

namespace App\Controller\API;

use OpenApi\Attributes as OA;
use App\Services\Products\ProductServiceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ApiProductsController extends AbstractController
{
    private ProductServiceHandler $productService;

    public function __construct(ProductServiceHandler $productService)
    {
        $this->productService = $productService;
    }

    #[OA\Get(
        path: '/api/products',
        summary: 'Liste tous les produits',
        tags: ['Products'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Retourne la liste des produits',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'app', type: 'string', example: 'products')
                        ]
                    )
                )
            )
        ]
    )]
    #[Route('/products', name: 'get_product_collection', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();

        return $this->json($products);
    }


    #[OA\Patch(
        path: '/api/products/{id}/edit',
        summary: 'Met à jour un produit existant',
        tags: ['Products'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1),
                description: "L'ID du produit à mettre à jour"
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'label', type: 'string', example: 'Produit mis à jour'),
                    new OA\Property(property: 'details', type: 'string', example: 'Détails mis à jour'),
                    new OA\Property(property: 'price', type: 'number', format: 'float', example: 29.99),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Produit mis à jour avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'label', type: 'string', example: 'Produit mis à jour'),
                        new OA\Property(property: 'details', type: 'string', example: 'Détails mis à jour'),
                        new OA\Property(property: 'price', type: 'number', format: 'float', example: 29.99),
                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2024-10-14T12:00:00Z'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Produit non trouvé'
            )
        ]
    )]    
    #[Route('/products/{id}/edit', name: 'update_product_item', methods: ['PATCH'])]
    public function productUpdate(Request $request, int $id): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $product = $this->productService->updateProductItem($id, $content);

        return $this->json($product);
    }


    #[OA\Get(
        path: '/api/products/{id}',
        summary: 'Retourne un produit spécifique',
        tags: ['Products'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1),
                description: "L'ID du produit à récupérer"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails d\'un produit',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'app', type: 'string', example: 'products')
                    ]
                )
            )
        ]
    )]
    #[Route('/products/{id}', name: 'get_product_item', methods: ['GET'])]
    public function productItem(int $id): JsonResponse
    {
        $product = $this->productService->getProductItem($id);

        return $this->json($product);
    }

    #[OA\Post(
        path: '/api/products/new',
        summary: 'Ajoute un nouveau produit',
        tags: ['Products'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'label', type: 'string', example: 'Produit 1'),
                    new OA\Property(property: 'details', type: 'string', example: 'Détails du produit'),
                    new OA\Property(property: 'price', type: 'number', format: 'float', example: 19.99),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Produit ajouté avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'label', type: 'string', example: 'Produit 1'),
                        new OA\Property(property: 'details', type: 'string', example: 'Détails du produit'),
                        new OA\Property(property: 'price', type: 'number', format: 'float', example: 19.99),
                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2024-10-13T12:00:00Z'),
                    ]
                )
            )
        ]
    )]
    #[Route('/products/new', name: 'create_product_item', methods: ['POST'])]
    public function productAdd(Request $request): JsonResponse
    {
        $content = $request->getContent() ?? null;
        $product = $this->productService->postProductItem($content);

        return $this->json($product);
    }
}
