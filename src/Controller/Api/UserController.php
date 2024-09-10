<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('api/user', name: 'api_user')]
class UserController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[Route('s', name: '_all', methods: ['GET'])]
    public function index(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $users = $userRepository->findAll();
        $data = $serializer->serialize($users, 'json', ['groups' => 'api_users']);
        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/register', name: '_register', methods: ['POST'])]
    public function register(
        Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setLastname($data['lastname']);
        $user->setFirstname($data['firstname']);
        $user->setAddress($data['address']);
        $user->setCity($data['city']);
        $user->setPostalCode($data['postalCode']);
        $user->setPhone($data['phone']);
        $user->setNameAsso($data['nameAsso']);
        $user->setSiret($data['siret']);
        $user->setWebsite($data['website']);
        $user->setImage($data['image']);
        $user->setRoles($user->getRoles());
        

        // $errors = $validator->validate($user);
        // if (count($errors) > 0) {
        //     $errorMessages = [];
        //     foreach ($errors as $error) {
        //         $errorMessages[] = $error->getMessage();
        //     }
        //     return new JsonResponse(['message' => "Echec lors de l'enregistrement", 'errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        // }

        $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Association enregistrée',
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'lastname' => $user->getLastname(),
                'firstname' => $user->getFirstname(),
                'address' => $user->getAddress(),
                'city' => $user->getCity(),
                'postalCode' => $user->getPostalCode(),
                'phone' => $user->getPhone(),
                'nameAsso' => $user->getNameAsso(),
                'siret' => $user->getSiret(),
                'website' => $user->getWebsite(),
                'image' => $user->getImage(),
                'roles' => $user->getRoles(),
            ]
        ], JsonResponse::HTTP_CREATED);
        
        

    }

    #[Route('/login', name: '_login', methods: ['POST'])]
    public function login(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email=($data['email']);
        $password=($data['password']);

        if (!$email || !$password) {
            return new JsonResponse(['message' => 'Veuillez remplir les deux champs'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $entityManager->getRepository(User::class)->findOneBy(["email" => $email]);
    }
    
}


