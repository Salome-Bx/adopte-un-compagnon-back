<?php

namespace App\Controller\Api;

use App\Entity\Form;
use App\Entity\Pet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormRepository;
use App\Repository\PetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use DateTime;
use Symfony\Component\HttpFoundation\Response;



#[Route('api/form', name: 'api_form')]
class FormController extends AbstractController
{
    /**
     * permet d'afficher tous les formulaires
     */
    #[Route('s', name: '_all', methods: ['GET'])]
    public function getAllForms(FormRepository $formRepository, SerializerInterface $serializer): JsonResponse
    {
        $forms = $formRepository->findAll();
        $data = $serializer->serialize($forms, 'json', ['groups' => 'api_forms']);
        return new JsonResponse($data, 200, [], true);
    }

    /**
     * permet de créer un formulaire
     */
    #[Route('/new', name: '_new', methods: ['POST'])]
    public function newForm(
        Request $request, 
        ValidatorInterface $validator, 
        EntityManagerInterface $entityManager, 
        SerializerInterface $serializer,
        PetRepository $petRepository,
        ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $form = new Form();
        $pet = new Pet();
        $form->setLastname($data['lastname']);
        $form->setFirstname($data['firstname']);
        $form->setEmail($data['email']);
        $form->setPostalCode($data['postalCode']);
        $form->setPhone($data['phone']);
        $form->setMessage($data['message']);
        $form->setDateForm(new DateTime(date("Y-m-d")));
        $form->setPet($petRepository->findOneBy(array("id" => $data['pet_id'])));
        
        

        $errors = $validator->validate($form);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['message' => "Echec lors de l'envoi", 'errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($form);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Demande crée avec succès',
            'form' => [
                'lastname' => $form->getLastname(),
                'firstname' => $form->getFirstname(),
                'email' => $form->getEmail(),
                'postal_code' => $form->getPostalCode(),
                'phone' => $form->getPhone(),
                'message' => $form->getMessage(),
                'date_form' => $form->getDateForm(),
                'pet_id' => $form->getPet(),
            ]
        ], JsonResponse::HTTP_CREATED);

    }

    /**
     * permet d'afficher les formulaires concernant une association
     */
    #[Route('/{id}/home/asso/forms', name: '_home_asso_forms', methods: ['GET'])]
    public function getFormsByAsso(UserRepository $userRepository, PetRepository $petRepository, Pet $pet, SerializerInterface $serializer, int $id): JsonResponse
    {
        $pets = $petRepository->findBy(["asso" => $id]);
        
        $data = $serializer->serialize($pets, 'json', ['groups' => 'api_home_asso_forms']);
        
        return new JsonResponse($data, 200, [], true);
    }


    

}




