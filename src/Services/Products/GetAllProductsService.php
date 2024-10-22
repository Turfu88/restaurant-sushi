<?php

namespace App\Services\Products;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class GetAllProductsService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère la collection de tous les produits.
     *
     * @return Product[] Retourne un tableau d'entités Product.
     */
    public function getAllProducts(): array
    {
        return $this->entityManager->getRepository(Product::class)->findAll();
    }
}
