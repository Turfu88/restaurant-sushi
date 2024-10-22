<?php

namespace App\Services\Bookings;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Services\Bookings\GetAllBookingsService;
use App\Services\Bookings\GetBookingItemService;
use App\Services\Bookings\PostBookingItemService;
use App\Services\MealTimes\GetMealTimeItemService;
use App\Services\Establishment\GetEstablishmentItemService;
// use App\Services\Bookings\BookingValidatorService;

class BookingServiceHandler
{
    private Serializer $serializer;
    private GetAllBookingsService $getAllBookingsService;
    private GetBookingItemService $getBookingItemService;
    private PostBookingItemService $postBookingItemService;
    private UpdateBookingItemService $updateBookingItemService;
    private GetEstablishmentItemService $getEstablishmentItemService;
    private GetMealTimeItemService $getMealTimeItemService;
    // private BookingValidatorService $bookingValidatorService;

    public function __construct(
        GetAllBookingsService $getAllBookingsService,
        GetBookingItemService $getBookingItemService,
        PostBookingItemService $postBookingItemService,
        UpdateBookingItemService $updateBookingItemService,
        GetEstablishmentItemService $getEstablishmentItemService,
        GetMealTimeItemService $getMealTimeItemService
        // BookingValidatorService $bookingValidatorService,
    ) {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
        ])];

        $this->serializer = new Serializer($normalizers, $encoders);
        $this->getAllBookingsService = $getAllBookingsService;
        $this->getBookingItemService = $getBookingItemService;
        $this->postBookingItemService = $postBookingItemService;
        $this->updateBookingItemService = $updateBookingItemService;
        $this->getEstablishmentItemService = $getEstablishmentItemService;
        $this->getMealTimeItemService = $getMealTimeItemService;
        // $this->bookingValidatorService = $bookingValidatorService;
    }

    /**
     * Sérialise tous les bookings récupérés.
     *
     * @return string JSON des bookings.
     */
    public function getAllBookings(): string
    {
        $bookings = $this->getAllBookingsService->getAllBookings();

        return $this->serializer->serialize($bookings, 'json');
    }

    /**
     * Sérialise un booking par ID.
     *
     * @param int $id
     * @return string JSON du booking.
     */
    public function getBookingItem(int $id): string
    {
        $booking = $this->getBookingItemService->getBookingItem($id);

        return $this->serializer->serialize($booking, 'json');
    }

    /**
     * Sérialise le booking créé à partir du contenu JSON.
     *
     * @param string $content Contenu JSON du booking à créer.
     * @return string JSON du booking créé.
     */
    public function postBookingItem(string $content): string
    {
        $requestData = json_decode($content, true);
        $requestData['establishment'] = $this->getEstablishmentItemService->getEstablishmentItem($requestData['establishment']);
        $requestData['mealTime'] = $this->getMealTimeItemService->getMealTimeItem($requestData['mealTime']);
        // $this->bookingValidatorService->validate($requestData);
        $booking = $this->postBookingItemService->postBookingItem($requestData);

        return $this->serializer->serialize($booking, 'json');
    }

    /**
     * Sérialise le booking créé à partir du contenu JSON.
     *
     * @param string $content Contenu JSON du booking à créer.
     * @return string JSON du booking créé.
     */
    public function updateBookingItem(int $id, string $content): string
    {
        $requestData = json_decode($content, true);
        $booking = $this->getBookingItemService->getBookingItem($id);
        $requestData['establishment'] = $this->getEstablishmentItemService->getEstablishmentItem($requestData['establishment']);
        $requestData['mealTime'] = $this->getMealTimeItemService->getMealTimeItem($requestData['mealTime']);
        //$this->bookingValidatorService->validate($requestData);
        $booking = $this->updateBookingItemService->updateBookingItem($booking, $requestData);

        return $this->serializer->serialize($booking, 'json');
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
