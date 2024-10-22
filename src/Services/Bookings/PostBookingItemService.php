<?php

namespace App\Services\Bookings;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;

class PostBookingItemService
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
    public function postBookingItem(array $bookingData): Booking
    {
        $booking = new Booking();
        $booking->setName($bookingData['name'])
                ->setEstablishment($bookingData['establishment'])
                ->setMealTime($bookingData['mealTime'])
                ->setPeopleNumber($bookingData['peopleNumber'])
                ->setPhoneNumber($bookingData['phoneNumber'])
                ->setCanceled(false)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($booking);
        $this->entityManager->flush();

        return $booking;
    }
}
