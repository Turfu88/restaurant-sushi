<?php

namespace App\Services\Menus;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;

class GetMenuItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère un produit par son ID.
     *
     * @param int $id
     * @return Menu|null Retourne le menu ou null si introuvable.
     */
    public function getMenuItem(int $id): ?Menu
    {
        return $this->entityManager->getRepository(Menu::class)->findOneBy(['id' => $id]);
    }
}
