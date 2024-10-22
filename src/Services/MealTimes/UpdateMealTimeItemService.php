<?php

namespace App\Services\MealTimes;

use App\Entity\MealTime;
use Doctrine\ORM\EntityManagerInterface;

class UpdateMealTimeItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Met à jour un service à partir des données fournies.
     *
     * @param array $mealTimeData
     * @return MealTime Le service mis à jour
     */
    public function updateMealTimeItem(MealTime $mealTime, array $mealTimeData): MealTime
    {        
        $mealTime->setDate(new \DateTimeImmutable(datetime: $mealTimeData['date']))
                ->setService($mealTimeData['service'])
                ->setOpen($mealTimeData['open'])
                ->setEstablishment($mealTimeData['establishment']);

        $this->entityManager->flush();

        return $mealTime;
    }
}
