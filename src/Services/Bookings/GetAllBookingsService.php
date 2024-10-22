<?php

namespace App\Services\Bookings;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;

class GetAllBookingsService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère la collection de toutes les réservations.
     *
     * @return Booking[] Retourne un tableau d'entités Booking.
     */
    public function getAllBookings(): array
    {
        return $this->entityManager->getRepository(Booking::class)->findAll();
    }
}
