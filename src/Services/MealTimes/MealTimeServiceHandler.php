<?php

namespace App\Services\MealTimes;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Services\MealTimes\GetAllMealTimesService;
use App\Services\MealTimes\GetMealTimeItemService;
use App\Services\MealTimes\PostMealTimeItemService;
use App\Services\MealTimes\GetUpcomingMealTimesService;
use App\Services\Establishment\GetEstablishmentItemService;

class MealTimeServiceHandler
{
    private Serializer $serializer;
    private GetAllMealTimesService $getAllMealTimesService;
    private GetUpcomingMealTimesService $getUpcomingMealTimesService;
    private GetMealTimeItemService $getMealTimeItemService;
    private PostMealTimeItemService $postMealTimeItemService;
    private UpdateMealTimeItemService $updateMealTimeItemService;
    private GetEstablishmentItemService $getEstablishmentItemService;

    public function __construct(
        GetAllMealTimesService $getAllMealTimesService,
        GetMealTimeItemService $getMealTimeItemService,
        PostMealTimeItemService $postMealTimeItemService,
        UpdateMealTimeItemService $updateMealTimeItemService,
        GetEstablishmentItemService $getEstablishmentItemService,
        GetUpcomingMealTimesService $getUpcomingMealTimesService
    ) {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
        ])];

        $this->serializer = new Serializer($normalizers, $encoders);
        $this->getAllMealTimesService = $getAllMealTimesService;
        $this->getMealTimeItemService = $getMealTimeItemService;
        $this->postMealTimeItemService = $postMealTimeItemService;
        $this->updateMealTimeItemService = $updateMealTimeItemService;
        $this->getEstablishmentItemService = $getEstablishmentItemService;
        $this->getUpcomingMealTimesService = $getUpcomingMealTimesService;
    }

    /**
     * Sérialise tous les services récupérés.
     *
     * @return string JSON des mealTimes.
     */
    public function getAllMealTimes(): string
    {
        $mealTimes = $this->getAllMealTimesService->getAllMealTimes();

        return $this->serializer->serialize($mealTimes, 'json');
    }

    /**
     * Sérialise les services à venir.
     *
     * @return string JSON des mealTimes.
     */
    public function getUpcomingMealTimes(): string
    {
        $mealTimes = $this->getUpcomingMealTimesService->getUpcomingMealTimes();

        return $this->serializer->serialize($mealTimes, 'json');
    }
    

    /**
     * Sérialise un mealTime par ID.
     *
     * @param int $id
     * @return string JSON du mealTime.
     */
    public function getMealTimeItem(int $id): string
    {
        $mealTime = $this->getMealTimeItemService->getMealTimeItem($id);

        return $this->serializer->serialize($mealTime, 'json');
    }

    /**
     * Sérialise le service créé à partir du contenu JSON.
     *
     * @param string $content Contenu JSON du service à créer.
     * @return string JSON du service créé.
     */
    public function postMealTimeItem(string $content): string
    {
        $requestData = json_decode($content, true);
        $requestData['establishment'] = $this->getEstablishmentItemService->getEstablishmentItem($requestData['establishment']);
        // $this->mealTimeValidatorService->validate($requestData);
        $mealTime = $this->postMealTimeItemService->postMealTimeItem($requestData);

        return $this->serializer->serialize($mealTime, 'json');
    }

    /**
     * Sérialise le mealTime créé à partir du contenu JSON.
     *
     * @param string $content Contenu JSON du mealTime à créer.
     * @return string JSON du mealTime créé.
     */
    public function updateMealTimeItem(int $id, string $content): string
    {
        $requestData = json_decode($content, true);
        $mealTime = $this->getMealTimeItemService->getMealTimeItem($id);
        $requestData['establishment'] = $this->getEstablishmentItemService->getEstablishmentItem($requestData['establishment']);
        //$this->mealTimeValidatorService->validate($requestData);
        $mealTime = $this->updateMealTimeItemService->updateMealTimeItem($mealTime, $requestData);

        return $this->serializer->serialize($mealTime, 'json');
    }

    /**
     * Utilisé pour les test unitaires uniquement
     * @param \Symfony\Component\Serializer\Serializer $serializer
     * @return void
     */
    public function setSerializer(Serializer $serializer): void
    {
        $this->serializer = $serializer;
    }
}
