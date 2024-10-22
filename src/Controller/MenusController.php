<?php

namespace App\Controller;

use App\Services\Menus\MenuServiceHandler;
use App\Services\Establishment\EstablishmentServiceHandler;
use  App\Services\Products\ProductServiceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenusController extends AbstractController
{
    private MenuServiceHandler $menuService;
    private EstablishmentServiceHandler $establishmentService;
    private ProductServiceHandler $productService;

    public function __construct(
        MenuServiceHandler $menuService,
        EstablishmentServiceHandler $establishmentService,
        ProductServiceHandler $productService
    ) {
        $this->menuService = $menuService;
        $this->establishmentService = $establishmentService;
        $this->productService = $productService;
    }

    #[Route('/menus', name: 'app_menus')]
    public function index(): Response
    {
        $menus = $this->menuService->getAllMenus();

        return $this->render('menu/menusCollection.html.twig', [
            'app' => 'menus',
            'menus' => $menus
        ]);
    }

    #[Route('/menus/{id}/composer', name: 'app_menu_composer')]
    public function menuComposer(int $id): Response
    {
        $menu = $this->menuService->getMenuItem($id);
        $products = $this->productService->getAllProducts();

        return $this->render('menu/menuComposer.html.twig', [
            'app' => 'menuComposer',
            'menu'=> $menu,
            'products' => $products
        ]);
    }

    #[Route('/menus/{id}/edit', name: 'app_menu_edit')]
    public function menuEdit(int $id): Response
    {
        $menu = $this->menuService->getMenuItem($id);
        $establishments = $this->establishmentService->getAllEstablishments();

        return $this->render('menu/menuForm.html.twig', [
            'app' => 'menuForm',
            'menu'=> $menu,
            'establishments' => $establishments
        ]);
    }

    

    #[Route('/menus/new', name: 'app_menu_add')]
    public function menuAdd(): Response
    {
        $establishments = $this->establishmentService->getAllEstablishments();

        return $this->render('menu/menuForm.html.twig', [
            'app' => 'menuForm',
            'menu'=> null,
            'establishments' => $establishments
        ]);
    }

    #[Route('/menus/{id}', name: 'app_menu_details')]
    public function menuItem(int $id): Response
    {
        $menu = $this->menuService->getMenuItem($id);

        return $this->render('menu/menuDetails.html.twig', [
            'app' => 'menuDetails',
            'menu'=> $menu
        ]);
    }
}
