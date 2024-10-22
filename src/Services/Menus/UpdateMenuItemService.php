<?php

namespace App\Services\Menus;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;

class UpdateMenuItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Crée un nouveau menu à partir des données fournies.
     *
     * @param array $menuData
     * @return Menu Le menu nouvellement créé.
     */
    public function updateMenuItem(Menu $menu, array $menuData): Menu
    {
        $menu->setTitle($menuData['title'])
                ->setDescription($menuData['description'])
                ->setEstablishment($menuData['establishment'])
                ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->flush();

        return $menu;
    }
}
