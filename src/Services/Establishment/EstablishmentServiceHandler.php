<?php

namespace App\Services\Establishment;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Services\Establishment\GetAllEstablishmentsService;
use App\Services\Establishment\GetEstablishmentItemService;
use App\Services\Establishment\PostEstablishmentItemService;


class EstablishmentServiceHandler
{
    private Serializer $serializer;
    private GetAllEstablishmentsService $getAllEstablishmentsService;
    private GetEstablishmentItemService $getEstablishmentItemService;
    private PostEstablishmentItemService $postEstablishmentItemService;
    private UpdateEstablishmentItemService $updateEstablishmentItemService;

    public function __construct(
        GetAllEstablishmentsService $getAllEstablishmentsService,
        GetEstablishmentItemService $getEstablishmentItemService,
        PostEstablishmentItemService $postEstablishmentItemService,
        UpdateEstablishmentItemService $updateEstablishmentItemService
    ) {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
        ])];
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->getAllEstablishmentsService = $getAllEstablishmentsService;
        $this->getEstablishmentItemService = $getEstablishmentItemService;
        $this->postEstablishmentItemService = $postEstablishmentItemService;
        $this->updateEstablishmentItemService = $updateEstablishmentItemService;
    }

    /**
     * @return string JSON des établissements.
     */
    public function getAllEstablishments(): string
    {
        $establishments = $this->getAllEstablishmentsService->getAllEstablishments();
        return $this->serializer->serialize($establishments, 'json');
    }

    /**
     * @param int $id
     * @return string JSON d'un établissement.
     */
    public function getEstablishmentItem(int $id): string
    {
        $establishment = $this->getEstablishmentItemService->getEstablishmentItem($id);
        return $this->serializer->serialize($establishment, 'json');
    }

    /**
     * Sérialise le produit créé à partir du contenu JSON.
     *
     * @param string $content Contenu JSON du produit à créer.
     * @return string JSON du produit créé.
     */
    public function postEstablishmentItem(string $content): string
    {
        $establishmentData = json_decode($content, true);
        $product = $this->postEstablishmentItemService->postEstablishmentItem($establishmentData);
        return $this->serializer->serialize($product, 'json');
    }

    /**
     * Sérialise l'établissement mis à jour à partir du contenu JSON.
     *
     * @param string $content Contenu JSON de l'établissement à modifier.
     * @return string JSON d'établissement modifié.
     */
    public function updateEstablishmentItem(int $id, string $content): string
    {
        $establishmentData = json_decode($content, true);
        $establishment = $this->getEstablishmentItemService->getEstablishmentItem($id);
        $establishment = $this->updateEstablishmentItemService->updateEstablishmentItem($establishment, $establishmentData);
        return $this->serializer->serialize($establishment, 'json');
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
