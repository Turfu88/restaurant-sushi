<?php

namespace App\Controller;

use App\Services\StaffMembers\StaffMemberServiceHandler;
use App\Services\Establishment\EstablishmentServiceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StaffMembersController extends AbstractController
{
    private StaffMemberServiceHandler $staffMemberService;
    private EstablishmentServiceHandler $establishmentService;

    public function __construct(
        StaffMemberServiceHandler $staffMemberService,
        EstablishmentServiceHandler $establishmentService,
    ) {
        $this->staffMemberService = $staffMemberService;
        $this->establishmentService = $establishmentService;
        $this->staffMemberService = $staffMemberService;
    }

    #[Route('/staff-members', name: 'app_staff_members')]
    public function index(): Response
    {
        $staffMembers = $this->staffMemberService->getAllStaffMembers();

        return $this->render('staffMember/staffMembersCollection.html.twig', [
            'app' => 'staffMembers',
            'staffMembers' => $staffMembers
        ]);
    }

    #[Route('/staff-members/{id}/affectations', name: 'app_staff_member_affectations')]
    public function staffMemberComposer(int $id): Response
    {
        $staffMember = $this->staffMemberService->getStaffMemberItem($id);
        $establishments = $this->establishmentService->getAllEstablishments();

        return $this->render('staffMember/staffMemberAffectations.html.twig', [
            'app' => 'staffMemberAffectations',
            'staffMember'=> $staffMember,
            'establishments' => $establishments
        ]);
    }

    #[Route('/staff-members/{id}/edit', name: 'app_staff_member_edit')]
    public function staffMemberEdit(int $id): Response
    {
        $staffMember = $this->staffMemberService->getStaffMemberItem($id);

        return $this->render('staffMember/staffMemberForm.html.twig', [
            'app' => 'staffMemberForm',
            'staffMember'=> $staffMember,
        ]);
    }

    #[Route('/staff-members/new', name: 'app_staff_member_add')]
    public function staffMemberAdd(): Response
    {
        $establishments = $this->establishmentService->getAllEstablishments();

        return $this->render('staffMember/staffMemberForm.html.twig', [
            'app' => 'staffMemberForm',
            'staffMember'=> null,
            'establishments' => $establishments
        ]);
    }

    #[Route('/staff-members/{id}', name: 'app_staff_member_details')]
    public function staffMemberItem(int $id): Response
    {
        $staffMember = $this->staffMemberService->getStaffMemberItem($id);

        return $this->render('staffMember/staffMemberDetails.html.twig', [
            'app' => 'staffMemberDetails',
            'staffMember'=> $staffMember
        ]);
    }
}
