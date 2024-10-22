<?php

namespace App\Services\StaffMembers;

use App\Entity\StaffMember;
use Doctrine\ORM\EntityManagerInterface;

class GetStaffMemberItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère un employé par son ID.
     *
     * @param int $id
     * @return StaffMember|null Retourne un employé ou null si introuvable.
     */
    public function getStaffMemberItem(int $id): ?StaffMember
    {
        return $this->entityManager->getRepository(StaffMember::class)->findOneBy(['id' => $id]);
    }
}
