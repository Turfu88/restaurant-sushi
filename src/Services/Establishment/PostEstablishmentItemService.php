<?php

namespace App\Services\Establishment;

use App\Entity\Establishment;
use Doctrine\ORM\EntityManagerInterface;

class PostEstablishmentItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Crée un nouvel établissment à partir des données fournies.
     *
     * @param array $establishmentData
     * @return Establishment Le produit nouvellement créé.
     */
    public function postEstablishmentItem(array $establishmentData): Establishment
    {
        $establishment = new Establishment();
        $establishment->setName($establishmentData['name'])
                ->setAddress($establishmentData['address'])
                ->setTimeLimitBeforeCancel($establishmentData['timeLimitBeforeCancel'])
                ->setAvailableSeats($establishmentData['availableSeats'])
                ->setOpen($establishmentData['open'])
                ->setOpeningAdvancedBookingDays($establishmentData['openingAdvancedBookingDays'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($establishment);
        $this->entityManager->flush();

        return $establishment;
    }
}
