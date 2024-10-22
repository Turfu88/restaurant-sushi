<?php

namespace App\ProductService\Tests;

use App\Entity\Product;
use App\Services\Products\PostProductItemService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class PostProductItemServiceTest extends TestCase
{
    public function testPostProductItemCreatesAndPersistsProduct(): void
    {
        // Création de mocks pour EntityManager
        $entityManager = $this->createMock(EntityManagerInterface::class);

        // On vérifie que les méthodes persist et flush sont appelées
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Product::class));

        $entityManager->expects($this->once())
            ->method('flush');

        // Instanciation du service à tester
        $postProductItemService = new PostProductItemService($entityManager);

        // Les données JSON simulées du produit
        $productData = [
            'label' => 'New Product',
            'details' => 'New Product Details',
            'price' => 100.0
        ];

        // Exécution du service
        $product = $postProductItemService->postProductItem($productData);

        // Vérification des propriétés du produit
        $this->assertSame('New Product', $product->getLabel());
        $this->assertSame('New Product Details', $product->getDetails());
        $this->assertSame(100.0, $product->getPrice());
        $this->assertInstanceOf(\DateTimeImmutable::class, $product->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $product->getUpdatedAt());
    }
}
