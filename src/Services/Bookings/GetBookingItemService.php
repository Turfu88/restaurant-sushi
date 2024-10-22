<?php

namespace App\Services\Bookings;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;

class GetBookingItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère une réservation par son ID.
     *
     * @param int $id
     * @return Booking|null Retourne une réservation ou null si introuvable.
     */
    public function getBookingItem(int $id): ?Booking
    {
        return $this->entityManager->getRepository(Booking::class)->findOneBy(['id' => $id]);
    }
}
