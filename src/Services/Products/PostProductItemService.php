<?php

namespace App\Services\Products;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class PostProductItemService
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
    public function postProductItem(array $productData): Product
    {
        $product = new Product();
        $product->setLabel($productData['label'])
                ->setDetails($productData['details'])
                ->setPrice($productData['price'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }
}
