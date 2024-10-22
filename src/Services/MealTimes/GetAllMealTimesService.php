<?php

namespace App\Services\MealTimes;

use App\Entity\MealTime;
use Doctrine\ORM\EntityManagerInterface;

class GetAllMealTimesService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère la collection de tous les services
     *
     * @return MealTime[] Retourne un tableau d'entités MealTime.
     */
    public function getAllMealTimes(): array
    {
        return $this->entityManager->getRepository(MealTime::class)->findAll();
    }
}
