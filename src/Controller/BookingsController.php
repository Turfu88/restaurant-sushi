<?php

namespace App\Controller;

use App\Services\Bookings\BookingServiceHandler;
use App\Services\Establishment\EstablishmentServiceHandler;
use App\Services\Products\ProductServiceHandler;
use App\Services\MealTimes\MealTimeServiceHandler;;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookingsController extends AbstractController
{
    private BookingServiceHandler $bookingService;
    private EstablishmentServiceHandler $establishmentService;
    private ProductServiceHandler $productService;
    private MealTimeServiceHandler $mealTimeService;

    public function __construct(
        BookingServiceHandler $bookingService,
        EstablishmentServiceHandler $establishmentService,
        ProductServiceHandler $productService,
        MealTimeServiceHandler $mealTimeService
    ) {
        $this->bookingService = $bookingService;
        $this->establishmentService = $establishmentService;
        $this->productService = $productService;
        $this->mealTimeService = $mealTimeService;
    }

    #[Route('/bookings', name: 'app_bookings')]
    public function index(): Response
    {
        $bookings = $this->bookingService->getAllBookings();

        return $this->render('booking/bookingsCollection.html.twig', [
            'app' => 'bookings',
            'bookings' => $bookings
        ]);
    }

    #[Route('/bookings/new', name: 'app_booking_add')]
    public function bookingAdd(): Response
    {
        $establishments = $this->establishmentService->getAllEstablishments();
        $mealTimes = $this->mealTimeService->getUpcomingMealTimes();

        return $this->render('booking/bookingForm.html.twig', [
            'app' => 'bookingForm',
            'booking'=> null,
            'establishments' => $establishments,
            'mealTimes' => $mealTimes
        ]);
    }

    #[Route('/bookings/{id}/edit', name: 'app_booking_edit')]
    public function bookingEdit(int $id): Response
    {
        $booking = $this->bookingService->getBookingItem($id);
        $establishments = $this->establishmentService->getAllEstablishments();
        $mealTimes = $this->mealTimeService->getUpcomingMealTimes();

        return $this->render('booking/bookingForm.html.twig', [
            'app' => 'bookingForm',
            'booking'=> $booking,
            'establishments' => $establishments,
            'mealTimes' => $mealTimes
        ]);
    }

    #[Route('/bookings/{id}', name: 'app_booking_details')]
    public function bookingItem(int $id): Response
    {
        $booking = $this->bookingService->getBookingItem($id);

        return $this->render('booking/bookingDetails.html.twig', [
            'app' => 'bookingDetails',
            'booking'=> $booking
        ]);
    }
}
