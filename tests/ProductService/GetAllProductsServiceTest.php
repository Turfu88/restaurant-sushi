<?php

namespace App\ProductService\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;
use App\Services\Products\GetAllProductsService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class GetAllProductsServiceTest extends TestCase
{
    public function testGetAllProductsReturnsArrayOfProducts(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $productRepository = $this->createMock(EntityRepository::class);

        // Simulation des données renvoyées par le repository
        $product1 = new Product();
        $product1->setLabel('Product 1')->setDetails('Details 1')->setPrice(10.0);
        $product2 = new Product();
        $product2->setLabel('Product 2')->setDetails('Details 2')->setPrice(20.0);
        $productList = [$product1, $product2];

        // On simule que le repository renvoie la liste des produits
        $productRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($productList);

        // On simule que l'EntityManager renvoie le repository de produits
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->with(Product::class)
            ->willReturn($productRepository);

        // Instanciation du service à tester
        $getAllProductsService = new GetAllProductsService($entityManager);

        // Exécution du service et vérification du résultat
        $result = $getAllProductsService->getAllProducts();
        $this->assertSame($productList, $result);
    }
}
