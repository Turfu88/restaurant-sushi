<?php

namespace App\Services\StaffMembers;

use App\Entity\StaffMember;
use Doctrine\ORM\EntityManagerInterface;

class ToggleStaffMemberEstablishmentService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Ajoute un produit dans un employé
     *
     * @param array $requestData
     * @return StaffMember L'employé mis à jour.
     */
    public function addStaffMemberEstablishment(StaffMember $staffMember,array $requestData): StaffMember
    {
        $staffMember->addEstablishment($requestData['establishment']);
        $this->entityManager->flush();

        return $staffMember;
    }

    /**
     * Retire un produit dans un employé
     *
     * @param array $requestData
     * @return StaffMember L'employé mis à jour.
     */
    public function removeStaffMemberEstablishment(StaffMember $staffMember, array $requestData): StaffMember
    {
        $staffMember->removeEstablishment($requestData['establishment']);
        $this->entityManager->flush();

        return $staffMember;
    }
}
