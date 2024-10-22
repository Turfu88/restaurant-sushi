<?php

namespace App\Services\StaffMembers;

use App\Entity\StaffMember;
use Doctrine\ORM\EntityManagerInterface;

class GetAllStaffMembersService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère la collection de tous les employés.
     *
     * @return StaffMember[] Retourne un tableau d'entités StaffMember.
     */
    public function getAllStaffMembers(): array
    {
        return $this->entityManager->getRepository(StaffMember::class)->findAll();
    }
}
