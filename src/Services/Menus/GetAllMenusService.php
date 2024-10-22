<?php

namespace App\Services\Menus;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;

class GetAllMenusService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère la collection de tous les menus.
     *
     * @return Menu[] Retourne un tableau d'entités Menu.
     */
    public function getAllMenus(): array
    {
        return $this->entityManager->getRepository(Menu::class)->findAll();
    }
}
