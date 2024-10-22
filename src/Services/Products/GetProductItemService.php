<?php

namespace App\Services\Products;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class GetProductItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère un produit par son ID.
     *
     * @param int $id
     * @return Product|null Retourne le produit ou null si introuvable.
     */
    public function getProductItem(int $id): ?Product
    {
        return $this->entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);
    }
}
