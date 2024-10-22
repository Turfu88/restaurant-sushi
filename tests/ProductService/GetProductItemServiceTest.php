<?php

namespace App\ProductService\Tests;

use App\Entity\Product;
use App\Services\Products\GetProductItemService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class GetProductItemServiceTest extends TestCase
{
    public function testGetProductItemReturnsProduct(): void
    {
        // Création de mocks pour EntityManager et EntityRepository
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $productRepository = $this->createMock(EntityRepository::class);

        // Simulation du produit renvoyé par le repository
        $product = new Product();
        $product->setLabel('Test Product')->setDetails('Test Details')->setPrice(30.0);

        // On simule que le repository renvoie un produit
        $productRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 1])
            ->willReturn($product);

        // On simule que l'EntityManager renvoie le repository de produits
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->with(Product::class)
            ->willReturn($productRepository);

        // Instanciation du service à tester
        $getProductItemService = new GetProductItemService($entityManager);

        // Exécution du service et vérification du résultat
        $result = $getProductItemService->getProductItem(1);
        $this->assertSame($product, $result);
    }

    public function testGetProductItemReturnsNullWhenNotFound(): void
    {
        // Création de mocks pour EntityManager et EntityRepository
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $productRepository = $this->createMock(EntityRepository::class);

        // On simule que le repository renvoie null (produit non trouvé)
        $productRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 1])
            ->willReturn(null);

        // On simule que l'EntityManager renvoie le repository de produits
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->with(Product::class)
            ->willReturn($productRepository);

        // Instanciation du service à tester
        $getProductItemService = new GetProductItemService($entityManager);

        // Exécution du service et vérification du résultat
        $result = $getProductItemService->getProductItem(1);
        $this->assertNull($result);
    }
}
