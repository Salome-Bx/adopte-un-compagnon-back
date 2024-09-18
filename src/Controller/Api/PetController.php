<?php

namespace App\Controller\Api;

use App\Entity\Pet;
use App\Repository\PetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('api/pet', name: 'api_pet')]
class PetController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    #[Route('/{id}', name: '_id', methods: ['GET'])]
    public function petById(PetRepository $petRepository, SerializerInterface $serializer, int $id): JsonResponse 
    {
        $data = $petRepository->find($id);
        return $this->json($data, context: ['groups' => 'api_pet_id']);
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

    #[Route('/admin/new', name: '_admin_pet_new', methods: ['POST'])]
    public function createPet(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $pet = new Pet();
        $pet->setName($data['name']);
        $pet->setBirthyear($data['birthyear']);
        $pet->setGender($data['gender']);
        $pet->setQuickDescription($data['quick_description']);
        $pet->setDescription($data['description']);
        $pet->setGetAlongCats($data['get_along_cats']);
        $pet->setGetAlongDogs($data['get_along_dogs']);
        $pet->setGetAlongChildren($data['get_along_children']);
        $pet->setEntryDate($data['entry_date']);
        $pet->setSos($data['sos']);
        $pet->setRace($data['race']);
        $pet->setCategorisedDog($data['categorised_dog']);
        $pet->setImage($data['image']);
        $pet->setRegisterDate($data['register_date']);
        $pet->setUpdateDate($data['update_date']);

        $errors = $validator->validate($pet);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['message' => "Echec lors de l'enregistrement", 'errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($pet);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Animal crée avec succès',
            'pet' => [
                'id' => $pet->getId(),
                'name' => $pet->getName(),
                'birthyear' => $pet->getBirthyear(),
                'gender' => $pet->getGender(),
                'quick_description' => $pet->getQuickDescription(),
                'description' => $pet->getDescription(),
                'get_along_cats' => $pet->isGetAlongCats(),
                'get_along_dogs' => $pet->isGetAlongDogs(),
                'get_along_children' => $pet->isGetAlongChildren(),
                'entry_date' => $pet->getEntryDate(),
                'sos' => $pet->isSos(),
                'race' => $pet->getRace(),
                'categorised_dog' => $pet->getCategorisedDog(),
                'image' => $pet->getImage(),
                'register_date' => $pet->getRegisterDate(),
                'update_date' => $pet->getUpdateDate(), 
            ]
        ], JsonResponse::HTTP_OK);


    }

    #[Route('/admin/edit', name: '_admin_pet_edit', methods: ['POST'])]
    public function editPet(PetRepository $petRepository, SerializerInterface $serializer): JsonResponse
    {
        $sos = $petRepository->findBySOS();
        $data = $serializer->serialize($sos, 'json', ['groups' => 'api_pet_sos']);
        return new JsonResponse($data, 200, [], true);
    }
}
