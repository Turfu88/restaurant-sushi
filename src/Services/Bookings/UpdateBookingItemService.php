<?php

namespace App\Services\Bookings;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;

class UpdateBookingItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Crée une nouvelle réservation à partir des données fournies.
     *
     * @param array $bookingData
     * @return Booking La réservation nouvellement créée.
     */
    public function updateBookingItem(Booking $booking, array $bookingData): Booking
    {
        $booking->setName($bookingData['name'])
                ->setEstablishment($bookingData['establishment'])
                ->setMealTime($bookingData['mealTime'])
                ->setPeopleNumber($bookingData['peopleNumber'])
                ->setPhoneNumber($bookingData['phoneNumber'])
                ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->flush();

        return $booking;
    }
}
