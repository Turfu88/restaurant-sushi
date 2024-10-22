<?php

namespace App\Services\Products;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Services\Products\GetAllProductsService;
use App\Services\Products\GetProductItemService;
use App\Services\Products\PostProductItemService;


class ProductServiceHandler
{
    private Serializer $serializer;
    private GetAllProductsService $getAllProductsService;
    private GetProductItemService $getProductItemService;
    private PostProductItemService $postProductItemService;
    private UpdateProductItemService $updateProductItemService;

    public function __construct(
        GetAllProductsService $getAllProductsService,
        GetProductItemService $getProductItemService,
        PostProductItemService $postProductItemService,
        UpdateProductItemService $updateProductItemService
    ) {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
        ])];
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->getAllProductsService = $getAllProductsService;
        $this->getProductItemService = $getProductItemService;
        $this->postProductItemService = $postProductItemService;
        $this->updateProductItemService = $updateProductItemService;
    }

    /**
     * Sérialise tous les produits récupérés.
     *
     * @return string JSON des produits.
     */
    public function getAllProducts(): string
    {
        $products = $this->getAllProductsService->getAllProducts();
        return $this->serializer->serialize($products, 'json');
    }

    /**
     * Sérialise un produit par ID.
     *
     * @param int $id
     * @return string JSON du produit.
     */
    public function getProductItem(int $id): string
    {
        $product = $this->getProductItemService->getProductItem($id);
        return $this->serializer->serialize($product, 'json');
    }

    /**
     * Sérialise le produit créé à partir du contenu JSON.
     *
     * @param string $content Contenu JSON du produit à créer.
     * @return string JSON du produit créé.
     */
    public function postProductItem(string $content): string
    {
        $productData = json_decode($content, true);
        $product = $this->postProductItemService->postProductItem($productData);
        return $this->serializer->serialize($product, 'json');
    }

    /**
     * Sérialise le produit créé à partir du contenu JSON.
     *
     * @param string $content Contenu JSON du produit à créer.
     * @return string JSON du produit créé.
     */
    public function updateProductItem(int $id, string $content): string
    {
        $productData = json_decode($content, true);
        $product = $this->getProductItemService->getProductItem($id);
        $product = $this->updateProductItemService->updateProductItem($product, $productData);
        return $this->serializer->serialize($product, 'json');
    }

    /**
     * Utilisé pour les test unitaires uniquement
     * @param \Symfony\Component\Serializer\Serializer $serializer
     * @return void
     */
    public function setSerializer(Serializer $serializer): void
    {
        $this->serializer = $serializer;
    }
}
