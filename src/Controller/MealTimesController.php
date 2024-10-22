<?php

namespace App\Controller;

use App\Services\MealTimes\MealTimeServiceHandler;
use App\Services\Establishment\EstablishmentServiceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MealTimesController extends AbstractController
{
    private MealTimeServiceHandler $mealTimeService;
    private EstablishmentServiceHandler $establishmentService;

    public function __construct(
        MealTimeServiceHandler $mealTimeService,
        EstablishmentServiceHandler $establishmentService,
    ) {
        $this->mealTimeService = $mealTimeService;
        $this->establishmentService = $establishmentService;
    }

    #[Route('/meal-times', name: 'app_meal_times')]
    public function index(): Response
    {
        $mealTimes = $this->mealTimeService->getAllMealTimes();

        return $this->render('mealTime/mealTimesCollection.html.twig', [
            'app' => 'mealTimes',
            'mealTimes' => $mealTimes
        ]);
    }

    #[Route('/meal-times/{id}/edit', name: 'app_meal_time_edit')]
    public function mealTimeEdit(int $id): Response
    {
        $mealTime = $this->mealTimeService->getMealTimeItem($id);
        $establishments = $this->establishmentService->getAllEstablishments();

        return $this->render('mealTime/mealTimeForm.html.twig', [
            'app' => 'mealTimeForm',
            'mealTime'=> $mealTime,
            'establishments' => $establishments
        ]);
    }

    

    #[Route('/meal-times/new', name: 'app_meal_time_add')]
    public function mealTimeAdd(): Response
    {
        $establishments = $this->establishmentService->getAllEstablishments();

        return $this->render('mealTime/mealTimeForm.html.twig', [
            'app' => 'mealTimeForm',
            'mealTime'=> null,
            'establishments' => $establishments
        ]);
    }

    #[Route('/meal-times/{id}', name: 'app_meal_time_details')]
    public function mealTimeItem(int $id): Response
    {
        $mealTime = $this->mealTimeService->getMealTimeItem($id);

        return $this->render('mealTime/mealTimeDetails.html.twig', [
            'app' => 'mealTimeDetails',
            'mealTime'=> $mealTime
        ]);
    }
}
