<?php

namespace App\Services\MealTimes;

use App\Entity\MealTime;
use Doctrine\ORM\EntityManagerInterface;

class GetMealTimeItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère un service par son ID.
     *
     * @param int $id
     * @return MealTime|null Retourne un service ou null si introuvable.
     */
    public function getMealTimeItem(int $id): ?MealTime
    {
        return $this->entityManager->getRepository(MealTime::class)->findOneBy(['id' => $id]);
    }
}
