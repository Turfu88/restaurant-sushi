<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\Establishment\EstablishmentServiceHandler;


class EstablishmentController extends AbstractController
{
    private EstablishmentServiceHandler $establishmentService;

    public function __construct(EstablishmentServiceHandler $establishmentService)
    {
        $this->establishmentService = $establishmentService;
    }

    #[Route('/establishments', name: 'app_establishments')]
    public function index(): Response
    {
        $establishments = $this->establishmentService->getAllEstablishments();

        return $this->render('establishment/establishmentsCollection.html.twig', [
            'app' => 'establishments',
            'establishments' => $establishments
        ]);
    }

    #[Route('/establishments/{id}/edit', name: 'app_establishment_edit')]
    public function establishmentEdit(int $id): Response
    {
        $establishment = $this->establishmentService->getEstablishmentItem($id);

        return $this->render('establishment/establishmentForm.html.twig', [
            'app' => 'establishmentForm',
            'establishment'=> $establishment
        ]);
    }

    #[Route('/establishments/new', name: 'app_establishment_add')]
    public function establishmentAdd(): Response
    {
        return $this->render('establishment/establishmentForm.html.twig', [
            'app' => 'establishmentForm',
            'establishment'=> null
        ]);
    }

    #[Route('/establishments/{id}', name: 'app_establishment_details')]
    public function establishmentItem(int $id): Response
    {
        $establishment = $this->establishmentService->getEstablishmentItem($id);

        return $this->render('establishment/establishmentDetails.html.twig', [
            'app' => 'establishmentDetails',
            'establishment'=> $establishment
        ]);
    }
}
