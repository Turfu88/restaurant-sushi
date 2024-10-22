<?php

namespace App\Services\StaffMembers;

use App\Services\Users\PostUserItemService;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Services\StaffMembers\GetAllStaffMembersService;
use App\Services\StaffMembers\GetStaffMemberItemService;
use App\Services\StaffMembers\PostStaffMemberItemService;
use App\Services\StaffMembers\ToggleStaffMemberEstablishmentService;
use App\Services\Establishment\GetEstablishmentItemService;

class StaffMemberServiceHandler
{
    private Serializer $serializer;
    private GetAllStaffMembersService $getAllStaffMembersService;
    private GetStaffMemberItemService $getStaffMemberItemService;
    private PostStaffMemberItemService $postStaffMemberItemService;
    private UpdateStaffMemberItemService $updateStaffMemberItemService;
    private PostUserItemService $postUserItemService;
    private ToggleStaffMemberEstablishmentService $toggleStaffMemberEstablishmentService;
    private GetEstablishmentItemService $getEstablishmentItemService;

    public function __construct(
        GetAllStaffMembersService $getAllStaffMembersService,
        GetStaffMemberItemService $getStaffMemberItemService,
        PostStaffMemberItemService $postStaffMemberItemService,
        UpdateStaffMemberItemService $updateStaffMemberItemService,
        PostUserItemService $postUserItemService,
        ToggleStaffMemberEstablishmentService $toggleStaffMemberEstablishmentService,
        GetEstablishmentItemService $getEstablishmentItemService
    ) {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
        ])];
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->getAllStaffMembersService = $getAllStaffMembersService;
        $this->getStaffMemberItemService = $getStaffMemberItemService;
        $this->postStaffMemberItemService = $postStaffMemberItemService;
        $this->updateStaffMemberItemService = $updateStaffMemberItemService;
        $this->postUserItemService = $postUserItemService;
        $this->toggleStaffMemberEstablishmentService = $toggleStaffMemberEstablishmentService;
        $this->getEstablishmentItemService = $getEstablishmentItemService;
    }

    /**
     * Sérialise tous les employés récupérés.
     *
     * @return string JSON des employés.
     */
    public function getAllStaffMembers(): string
    {
        $staffMembers = $this->getAllStaffMembersService->getAllStaffMembers();
        return $this->serializer->serialize($staffMembers, 'json');
    }

    /**
     * Sérialise un employé par ID.
     *
     * @param int $id
     * @return string JSON de l'employé.
     */
    public function getStaffMemberItem(int $id): string
    {
        $staffMember = $this->getStaffMemberItemService->getStaffMemberItem($id);
        return $this->serializer->serialize($staffMember, 'json');
    }

    /**
     * Sérialise le employé créé à partir du contenu JSON.
     * Doit créer un nouvel utilisateur pour l'associer à l'employé.
     * @param string $content Contenu JSON du employé à créer.
     * @return string JSON du employé créé.
     */
    public function postStaffMemberItem(string $content): string
    {
        $staffMemberData = json_decode($content, true);
        $staffMemberData['user'] = $this->postUserItemService->postUserItem($staffMemberData);
        $staffMember = $this->postStaffMemberItemService->postStaffMemberItem($staffMemberData);
        return $this->serializer->serialize($staffMember, 'json');
    }

    /**
     * Sérialise l'employé créé à partir du contenu JSON.
     *
     * @param string $content Contenu JSON de l'employé à créer.
     * @return string JSON de l'employé créé.
     */
    public function updateStaffMemberItem(int $id, string $content): string
    {
        $staffMemberData = json_decode($content, true);
        $staffMember = $this->getStaffMemberItemService->getStaffMemberItem($id);
        $staffMember = $this->updateStaffMemberItemService->updateStaffMemberItem($staffMember, $staffMemberData);
        return $this->serializer->serialize($staffMember, 'json');
    }

    /**
     * Ajoute / Retire l'affectation d'un établissement à un employé 
     */
    public function toggleStaffMemberEstablishment(int $id, string $content): string
    {
        $requestData = json_decode($content, true);
        $staffMember = $this->getStaffMemberItemService->getStaffMemberItem($id);
        $requestData['establishment'] = $this->getEstablishmentItemService->getEstablishmentItem($requestData['establishmentId']);
        //$this->staffMemberValidatorService->validate($requestData);
        if ($requestData['action'] === 'add') {
            $staffMember = $this->toggleStaffMemberEstablishmentService->addStaffMemberEstablishment($staffMember, $requestData);
        }
        if ($requestData['action'] === 'remove') {
            $staffMember = $this->toggleStaffMemberEstablishmentService->removeStaffMemberEstablishment($staffMember, $requestData);
        }

        return $this->serializer->serialize($staffMember, 'json');
    }

    /**
     * Utilisé pour les test unitaires uniquement
     * @param \Symfony\Component\Serializer\Serializer $serializer
     * @return void
     */
    public function setSerializer(Serializer $serializer): void
    {
        $this->serializer = $serializer;
    }
}
