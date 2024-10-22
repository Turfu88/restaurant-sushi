<?php

namespace App\Services\MealTimes;

use App\Entity\MealTime;
use Doctrine\ORM\EntityManagerInterface;

class GetUpcomingMealTimesService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère la liste des MealTimes entre maintenant et un nombre de jours
     * dans le futur, défini par chaque établissement.
     *
     * @return MealTime[] Retourne un tableau d'entités MealTime.
     */
    public function getUpcomingMealTimes(): array
    {
        return $this->entityManager->getRepository(className: MealTime::class)->findBy(['is_open' => true]);
    }
}
