<?php

namespace App\Services\Menus;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;

class PostMenuItemService
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
    public function postMenuItem(array $menuData): Menu
    {
        $menu = new Menu();
        $menu->setTitle($menuData['title'])
                ->setDescription($menuData['description'])
                ->setEstablishment($menuData['establishment'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($menu);
        $this->entityManager->flush();

        return $menu;
    }
}
