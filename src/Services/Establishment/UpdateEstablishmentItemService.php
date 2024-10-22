<?php

namespace App\Services\Establishment;

use App\Entity\Establishment;
use Doctrine\ORM\EntityManagerInterface;

class UpdateEstablishmentItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Crée un nouveau produit à partir des données fournies.
     *
     * @param Establishment $establishment
     * @return Establishment Le produit nouvellement créé.
     */
    public function updateEstablishmentItem(Establishment $establishment, array $establishmentData): Establishment
    {
        $establishment->setName($establishmentData['name'])
                ->setAddress($establishmentData['address'])
                ->setTimeLimitBeforeCancel($establishmentData['timeLimitBeforeCancel'])
                ->setAvailableSeats($establishmentData['availableSeats'])
                ->setOpen($establishmentData['open'])
                ->setOpeningAdvancedBookingDays($establishmentData['openingAdvancedBookingDays'])
                ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->flush();

        return $establishment;
    }
}
