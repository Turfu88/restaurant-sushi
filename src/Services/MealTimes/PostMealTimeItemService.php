<?php

namespace App\Services\MealTimes;

use App\Entity\MealTime;
use Doctrine\ORM\EntityManagerInterface;

class PostMealTimeItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Crée un nouveau service à partir des données fournies.
     *
     * @param array $mealTimeData
     * @return MealTime Le service nouvellement créé.
     */
    public function postMealTimeItem(array $mealTimeData): MealTime
    {
        $mealTime = new MealTime();
        $mealTime->setDate(new \DateTimeImmutable(datetime: $mealTimeData['date']))
                ->setService($mealTimeData['service'])
                ->setOpen($mealTimeData['open'])
                ->setEstablishment($mealTimeData['establishment']);

        $this->entityManager->persist($mealTime);
        $this->entityManager->flush();

        return $mealTime;
    }
}
