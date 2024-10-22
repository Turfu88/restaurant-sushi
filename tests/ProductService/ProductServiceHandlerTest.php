<?php

namespace App\Tests;

use App\Entity\Product;
use App\Services\Products\GetAllProductsService;
use App\Services\Products\GetProductItemService;
use App\Services\Products\PostProductItemService;
use App\Services\Products\UpdateProductItemService;
use App\Services\Products\ProductServiceHandler;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use PHPUnit\Framework\TestCase;

class ProductServiceHandlerTest extends TestCase
{
    public function testGetAllProductsCallsGetAllProductsService(): void
    {
        // Création du mock pour GetAllProductsService
        $getAllProductsService = $this->createMock(GetAllProductsService::class);

        // Création de faux produits pour le test
        $mockProduct = $this->createMock(Product::class);
        $productsArray = [$mockProduct];

        // Simulation du comportement du service
        $getAllProductsService->expects($this->once())
            ->method('getAllProducts')
            ->willReturn($productsArray);

        // Création de mocks pour les autres services
        $getProductItemService = $this->createMock(GetProductItemService::class);
        $postProductItemService = $this->createMock(PostProductItemService::class);
        $updateProductItemService = $this->createMock(UpdateProductItemService::class);

        // Configuration du serializer avec JsonEncoder et ObjectNormalizer
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        // Instanciation du ProductServiceHandler avec les services mockés
        $productServiceHandler = new ProductServiceHandler(
            $getAllProductsService,
            $getProductItemService,
            $postProductItemService,
            $updateProductItemService
        );

        // Utilisation du serializer correct dans le service handler
        $productServiceHandler->setSerializer($serializer);

        // Exécution et vérification de la sérialisation
        $result = $productServiceHandler->getAllProducts();

        // Sérialisation attendue des produits avec le serializer configuré
        $expectedResult = $serializer->serialize($productsArray, 'json');

        // Vérification que le résultat est celui attendu
        $this->assertSame($expectedResult, $result);
    }

    public function testGetProductItemCallsGetProductItemService(): void
    {
        // Création du mock pour GetProductItemService
        $getProductItemService = $this->createMock(GetProductItemService::class);
        $updateProductItemService = $this->createMock(UpdateProductItemService::class);

        // Simulation du comportement du service
        $mockProduct = $this->createMock(Product::class);
        $getProductItemService->expects($this->once())
            ->method('getProductItem')
            ->with(1)
            ->willReturn($mockProduct);

        // Configuration du serializer
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        // Instanciation du ProductServiceHandler avec les services mockés
        $productServiceHandler = new ProductServiceHandler(
            $this->createMock(GetAllProductsService::class),
            $getProductItemService,
            $this->createMock(PostProductItemService::class),
            $updateProductItemService
        );

        // Utilisation du serializer correct dans le service handler
        $productServiceHandler->setSerializer($serializer);

        // Exécution et vérification de la sérialisation
        $result = $productServiceHandler->getProductItem(1);
        $expectedResult = $serializer->serialize($mockProduct, 'json');

        // Vérification que le résultat est celui attendu
        $this->assertSame($expectedResult, $result);
    }

    public function testPostProductItemCallsPostProductItemService(): void
    {
        // Création du mock pour PostProductItemService
        $postProductItemService = $this->createMock(PostProductItemService::class);
        $updateProductItemService = $this->createMock(UpdateProductItemService::class);

        // Simulation du comportement du service
        $jsonContent = '{"label": "New Product", "details": "New Details", "price": 50}';
        $mockProduct = $this->createMock(Product::class);
        $postProductItemService->expects($this->once())
            ->method('postProductItem')
            ->with(json_decode($jsonContent, true)) // Convertir le JSON en tableau
            ->willReturn($mockProduct);

        // Configuration du serializer
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        // Instanciation du ProductServiceHandler avec les services mockés
        $productServiceHandler = new ProductServiceHandler(
            $this->createMock(GetAllProductsService::class),
            $this->createMock(GetProductItemService::class),
            $postProductItemService,
            $updateProductItemService
        );

        // Utilisation du serializer correct dans le service handler
        $productServiceHandler->setSerializer($serializer);

        // Exécution et vérification de la sérialisation
        $result = $productServiceHandler->postProductItem($jsonContent);
        $expectedResult = $serializer->serialize($mockProduct, 'json');

        // Vérification que le résultat est celui attendu
        $this->assertSame($expectedResult, $result);
    }
}
