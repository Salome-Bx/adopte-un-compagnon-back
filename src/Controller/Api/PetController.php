<?php

namespace App\Controller\Api;

use App\Entity\Pet;
use App\Repository\PetRepository;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('api/pet', name: 'api_pet')]
class PetController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    #[Route('s', name: '_all', methods: ['GET'])]
    public function index(PetRepository $petRepository, SerializerInterface $serializer): JsonResponse
    {
        $pets = $petRepository->findAll();
        $data = $serializer->serialize($pets, 'json', ['groups' => 'api_pets']);
        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/sos', name: '_sos', methods: ['GET'])]
    public function AllSos(PetRepository $petRepository, SerializerInterface $serializer): JsonResponse
    {
        $sos = $petRepository->findBySOS();
        $data = $serializer->serialize($sos, 'json', ['groups' => 'api_pet_sos']);
        return new JsonResponse($data, 200, [], true);
    }
    
}
