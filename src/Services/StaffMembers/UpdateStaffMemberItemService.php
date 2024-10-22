<?php

namespace App\Services\StaffMembers;

use App\Entity\StaffMember;
use Doctrine\ORM\EntityManagerInterface;

class UpdateStaffMemberItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Crée un nouvel employé à partir des données fournies.
     *
     * @param StaffMember $staffMember
     * @param array $staffMemberData
     * @return StaffMember Employé nouvellement créé.
     */
    public function updateStaffMemberItem(StaffMember $staffMember, array $staffMemberData): StaffMember
    {
        $staffMember->setFirstname($staffMemberData['firstname'])
                ->setLastname($staffMemberData['lastname'])
                ->setRole($staffMemberData['role'])
                ->setActionsPermitted([])
                ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->flush();

        return $staffMember;
    }
}
