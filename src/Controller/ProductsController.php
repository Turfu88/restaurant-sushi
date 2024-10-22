<?php

namespace App\Controller;

use App\Services\Products\ProductServiceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductsController extends AbstractController
{
    private ProductServiceHandler $productService;

    public function __construct(ProductServiceHandler $productService)
    {
        $this->productService = $productService;
    }

    #[Route('/products', name: 'app_products')]
    public function index(): Response
    {
        $products = $this->productService->getAllProducts();

        return $this->render('product/productsCollection.html.twig', [
            'app' => 'products',
            'products' => $products
        ]);
    }

    #[Route('/products/{id}/edit', name: 'app_product_edit')]
    public function productEdit(int $id): Response
    {
        $product = $this->productService->getProductItem($id);

        return $this->render('product/productForm.html.twig', [
            'app' => 'productForm',
            'product'=> $product
        ]);
    }

    #[Route('/products/new', name: 'app_product_add')]
    public function productAdd(): Response
    {
        return $this->render('product/productForm.html.twig', [
            'app' => 'productForm',
            'product'=> null
        ]);
    }

    #[Route('/products/{id}', name: 'app_product_details')]
    public function productItem(int $id): Response
    {
        $product = $this->productService->getProductItem($id);

        return $this->render('product/productDetails.html.twig', [
            'app' => 'productDetails',
            'product'=> $product
        ]);
    }
}
