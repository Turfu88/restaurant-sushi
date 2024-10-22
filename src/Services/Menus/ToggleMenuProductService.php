<?php

namespace App\Services\Menus;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;

class ToggleMenuProductService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Ajoute un produit dans un menu
     *
     * @param array $requestData
     * @return Menu Le menu mis à jour.
     */
    public function addMenuProduct(Menu $menu,array $requestData): Menu
    {
        $menu->addProduct($requestData['product']);
        $this->entityManager->flush();

        return $menu;
    }

    /**
     * Retire un produit dans un menu
     *
     * @param array $requestData
     * @return Menu Le menu mis à jour.
     */
    public function removeMenuProduct(Menu $menu, array $requestData): Menu
    {
        $menu->removeProduct($requestData['product']);
        $this->entityManager->flush();

        return $menu;
    }
}
