<?php

namespace App\Services\Establishment;

use App\Entity\Establishment;
use Doctrine\ORM\EntityManagerInterface;

class GetEstablishmentItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère un produit par son ID.
     *
     * @param int $id
     * @return Establishment|null Retourne le produit ou null si introuvable.
     */
    public function getEstablishmentItem(int $id): ?Establishment
    {
        return $this->entityManager->getRepository(Establishment::class)->findOneBy(['id' => $id]);
    }
}
