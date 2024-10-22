<?php

namespace App\Services\Establishment;

use App\Entity\Establishment;
use Doctrine\ORM\EntityManagerInterface;

class GetAllEstablishmentsService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère la collection de tous les produits.
     *
     * @return Establishment[] Retourne un tableau d'entités Establishment.
     */
    public function getAllEstablishments(): array
    {
        return $this->entityManager->getRepository(Establishment::class)->findAll();
    }
}
