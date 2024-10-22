<?php

namespace App\Services\Products;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class UpdateProductItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Crée un nouveau produit à partir des données fournies.
     *
     * @param array $productData
     * @return Product Le produit nouvellement créé.
     */
    public function updateProductItem(Product $product, array $productData): Product
    {
        $product->setLabel($productData['label'])
                ->setDetails($productData['details'])
                ->setPrice($productData['price'])
                ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->flush();

        return $product;
    }
}
