<?php

namespace App\Services\Menus;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Services\Menus\GetAllMenusService;
use App\Services\Menus\GetMenuItemService;
use App\Services\Menus\PostMenuItemService;
use App\Services\Menus\ToggleMenuProductService;
use App\Services\Establishment\GetEstablishmentItemService;
use App\Services\Menus\MenuValidatorService;
use App\Services\Products\GetProductItemService;

class MenuServiceHandler
{
    private Serializer $serializer;
    private GetAllMenusService $getAllMenusService;
    private GetMenuItemService $getMenuItemService;
    private PostMenuItemService $postMenuItemService;
    private UpdateMenuItemService $updateMenuItemService;
    private GetEstablishmentItemService $getEstablishmentItemService;
    private MenuValidatorService $menuValidatorService;
    private ToggleMenuProductService $toggleMenuProductService;
    private GetProductItemService $getProductItemService;

    public function __construct(
        GetAllMenusService $getAllMenusService,
        GetMenuItemService $getMenuItemService,
        PostMenuItemService $postMenuItemService,
        UpdateMenuItemService $updateMenuItemService,
        GetEstablishmentItemService $getEstablishmentItemService,
        MenuValidatorService $menuValidatorService,
        ToggleMenuProductService $toggleMenuProductService,
        GetProductItemService $getProductItemService
    ) {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
        ])];

        $this->serializer = new Serializer($normalizers, $encoders);
        $this->getAllMenusService = $getAllMenusService;
        $this->getMenuItemService = $getMenuItemService;
        $this->postMenuItemService = $postMenuItemService;
        $this->updateMenuItemService = $updateMenuItemService;
        $this->getEstablishmentItemService = $getEstablishmentItemService;
        $this->menuValidatorService = $menuValidatorService;
        $this->toggleMenuProductService = $toggleMenuProductService;
        $this->getProductItemService = $getProductItemService;
    }

    /**
     * Sérialise tous les menus récupérés.
     *
     * @return string JSON des menus.
     */
    public function getAllMenus(): string
    {
        $menus = $this->getAllMenusService->getAllMenus();

        return $this->serializer->serialize($menus, 'json');
    }

    /**
     * Sérialise un menu par ID.
     *
     * @param int $id
     * @return string JSON du menu.
     */
    public function getMenuItem(int $id): string
    {
        $menu = $this->getMenuItemService->getMenuItem($id);

        return $this->serializer->serialize($menu, 'json');
    }

    /**
     * Sérialise le menu créé à partir du contenu JSON.
     *
     * @param string $content Contenu JSON du menu à créer.
     * @return string JSON du menu créé.
     */
    public function postMenuItem(string $content): string
    {
        $requestData = json_decode($content, true);
        $requestData['establishment'] = $this->getEstablishmentItemService->getEstablishmentItem($requestData['establishment']);
        $this->menuValidatorService->validate($requestData);
        $menu = $this->postMenuItemService->postMenuItem($requestData);

        return $this->serializer->serialize($menu, 'json');
    }

    /**
     * Sérialise le menu créé à partir du contenu JSON.
     *
     * @param string $content Contenu JSON du menu à créer.
     * @return string JSON du menu créé.
     */
    public function updateMenuItem(int $id, string $content): string
    {
        $requestData = json_decode($content, true);
        $menu = $this->getMenuItemService->getMenuItem($id);
        $requestData['establishment'] = $this->getEstablishmentItemService->getEstablishmentItem($requestData['establishment']);
        $this->menuValidatorService->validate($requestData);
        $menu = $this->updateMenuItemService->updateMenuItem($menu, $requestData);

        return $this->serializer->serialize($menu, 'json');
    }

    /**
     * 
     */
    public function toggleMenuProduct(int $id, string $content): string
    {
        $requestData = json_decode($content, true);
        $menu = $this->getMenuItemService->getMenuItem($id);
        $requestData['product'] = $this->getProductItemService->getProductItem($requestData['productId']);
        //$this->menuValidatorService->validate($requestData);
        if ($requestData['action'] === 'add') {
            $menu = $this->toggleMenuProductService->addMenuProduct($menu, $requestData);
        }
        if ($requestData['action'] === 'remove') {
            $menu = $this->toggleMenuProductService->removeMenuProduct($menu, $requestData);
        }

        return $this->serializer->serialize($menu, 'json');
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
