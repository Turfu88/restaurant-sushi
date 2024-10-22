<?php

namespace App\Services\StaffMembers;

use App\Entity\StaffMember;
use Doctrine\ORM\EntityManagerInterface;

class PostStaffMemberItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Crée un nouvel employé à partir des données fournies.
     *
     * @param array $staffMemberData
     * @return StaffMember L'employé nouvellement créé.
     */
    public function postStaffMemberItem(array $staffMemberData): StaffMember
    {
        $staffMember = new StaffMember();
        $staffMember->setFirstname($staffMemberData['firstname'])
                ->setLastname($staffMemberData['lastname'])
                ->setRole($staffMemberData['role'])
                ->setActionsPermitted([])
                ->setUser($staffMemberData['user'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($staffMember);
        $this->entityManager->flush();

        return $staffMember;
    }
}
