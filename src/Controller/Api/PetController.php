<?php

namespace App\Controller\Api;

use App\Entity\Pet;
use App\Entity\Species;
use App\Entity\User;
use App\Repository\PetRepository;
use App\Repository\SpeciesRepository;
use App\Repository\UserRepository;
use DateTime;
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

    #[Route('/sos', name: '_sos', methods: ['GET'])]
    public function AllSos(PetRepository $petRepository, SerializerInterface $serializer): JsonResponse
    {
        $sos = $petRepository->findBySOS();
        $data = $serializer->serialize($sos, 'json', ['groups' => 'api_pet_sos']);
        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/{id}', name: '_id', methods: ['GET'])]
    public function petById(PetRepository $petRepository, SerializerInterface $serializer, int $id, UserRepository $userRepository): JsonResponse 
    {
        $data = $petRepository->find($id);
        // $asso = $userRepository->findOneBy("id" -> $data)
        return $this->json($data, context: ['groups' => 'api_pet_id']);
    }



    #[Route('s', name: '_all', methods: ['GET'])]
    public function index(PetRepository $petRepository, SerializerInterface $serializer): JsonResponse
    {
        $pets = $petRepository->findAll();
        $data = $serializer->serialize($pets, 'json', ['groups' => 'api_pets']);
        return new JsonResponse($data, 200, [], true);
    }


    #[Route('/new', name: '_new', methods: ['POST'])]
    public function createPet(
        Request $request, 
        SerializerInterface $serializer, 
        EntityManagerInterface $entityManager, 
        ValidatorInterface $validator,
        SpeciesRepository $speciesRepository,
        UserRepository $userRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $pet = new Pet();
        $pet->setName($data['name']);
        $pet->setBirthyear(new DateTime(date("Y")));
        $pet->setGender($data['gender']);
        $pet->setQuickDescription($data['quick_description']);
        $pet->setDescription($data['description']);
        $pet->setGetAlongCats($data['get_along_cats']);
        $pet->setGetAlongDogs($data['get_along_dogs']);
        $pet->setGetAlongChildren($data['get_along_children']);
        $pet->setEntryDate(new DateTime(date("Y-m-d")));
        $pet->setSos($data['sos']);
        $pet->setRace($data['race']);
        $pet->setCategorisedDog($data['categorised_dog']);
        $pet->setImage($data['image']);
        $pet->setRegisterDate(new DateTime(date("Y-m-d")));
        $pet->setUpdateDate(new DateTime(date("Y-m-d")));
        $pet->setSpecies($speciesRepository->findOneBy(array("id" => $data['species_id'])));
        $pet->setAsso($userRepository->findOneBy(array("id" => $data['asso_id'])));

    

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
        ], JsonResponse::HTTP_CREATED);


    }

    #[Route('/{id}/edit', name: '_edit', methods: ['PUT'])]
    public function editPet(
        Request $request,
        Pet $pet,
        SerializerInterface $serializer, 
        EntityManagerInterface $entityManager,
        SpeciesRepository $speciesRepository,
        UserRepository $userRepository,
        ValidatorInterface $validator
        ): JsonResponse
    {
        
        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) {
            $pet->setName($data['name']);
        }
        if (isset($data['birthyear'])) {
            $pet->setBirthyear(new DateTime(date("Y")));
        }
        if (isset($data['gender'])) {
            $pet -> setGender($data['gender']);
        }
        if (isset($data['quick_description'])) {
            $pet->setQuickDescription($data['quick_description']); 
        }
        if (isset($data['description'])) {
            $pet->setDescription($data['description']); 
        }
        if (isset($data['get_along_cats'])) {
            $pet->setGetAlongCats($data['get_along_cats']); 
        }
        if (isset($data['get_along_dogs'])) {
            $pet->setGetAlongDogs($data['get_along_dogs']); 
        }
        if (isset($data['get_along_children'])) {
            $pet->setGetAlongChildren($data['get_along_children']); 
        }
        if (isset($data['entry_date'])) {
            $pet->setEntryDate(new DateTime(date("Y-m-d"))); 
        }
        if (isset($data['isSos'])) {
            $pet->setSos($data['sos']); 
        }
        if (isset($data['race'])) {
            $pet->setRace($data['race']);
        }
        if (isset($data['categorised_dog'])) {
            $pet->setCategorisedDog($data['categorised_dog']);
        }
        if (isset($data['image'])) {
            $pet->setImage($data['image']);
        }
        if (isset($data['register_date'])) {
            $pet->setRegisterDate(new DateTime(date("Y-m-d")));
        }
        if (isset($data['update_date'])) {
            $pet->setUpdateDate(new DateTime(date("Y-m-d"))); 
        }
        if (isset($data['species'])) {
            $pet->setSpecies($speciesRepository->findOneBy(array("id" => $data['species_id'])));
        }
        if (isset($data['asso_id'])) {
            $pet->setAsso($userRepository->findOneBy(array("id" => $data['asso_id'])));
        }


        $errors = $validator->validate($pet);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['message' => 'Echec de la modification', 'errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($pet);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Animal modifié avec succès',
            'pet' => [
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
        ], JsonResponse::HTTP_CREATED);

    }
    

        // #[Route('/account/pets', name: '_account', methods: ['GET'])]
    // public function getPetsByAsso(PetRepository $petRepository, SerializerInterface $serializer): JsonResponse
    // {
    //     try {
    //         $pets = $petRepository->findAllPetsByAsso($id);
    //         $data = $serializer->serialize($pets, 'json', ['groups' => 'api_pets_account_pets']);
    //         return new JsonResponse($data, 200, [], true);

    //     } catch (\Exception $e) {
    //         return $this->json([
    //             'error' => 'Une erreur est survenue lors de la récupération des animaux.',
    //             'details' => $e->getMessage()
    //         ], 500);
    //     }
    // }


    #[Route('/{id}/delete', name: '_pet_delete', methods: ['DELETE'])]
    public function deletePet(PetRepository $petRepository, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $pet = $petRepository->find($id);
        $entityManager->remove($pet);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Animal supprimé avec succès'], 200, [], true);
    }
}
