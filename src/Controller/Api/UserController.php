<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use OpenApi\Annotations\Response;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[Route('api/user', name: 'api_user')]
class UserController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[Route('/{id}', name: '_id', methods: ['GET'])]
    public function userById(UserRepository $userRepository, SerializerInterface $serializer, int $id): JsonResponse
    {
        $data = $userRepository->find($id);
        return $this->json($data, context: ['groups' => 'api_user_id']);
    }

    #[Route('/{id}/edit', name: '_edit', methods: ['PUT'])]
    
        public function editUser(
            Request $request,
            User $user,
            SerializerInterface $serializer, 
            EntityManagerInterface $entityManager,
            UserRepository $userRepository,
            ValidatorInterface $validator
            ): JsonResponse
        {
            
            $data = json_decode($request->getContent(), true);

            if (isset($data['email'])) {
                $user->setEmail($data['email']);
            }
            if (isset($data['password'])) {
                $user->setPassword($data['password']);
            }
            if (isset($data['lastname'])) {
                $user -> setLastname($data['lastname']);
            }
            if (isset($data['firstname'])) {
                $user->setFirstname($data['firstname']); 
            }
            if (isset($data['address'])) {
                $user->setAddress($data['address']); 
            }
            if (isset($data['city'])) {
                $user->setCity($data['city']); 
            }
            if (isset($data['postalCode'])) {
                $user->setPostalCode($data['postalCode']); 
            }
            if (isset($data['phone'])) {
                $user->setPhone($data['phone']); 
            }
            if (isset($data['nameAsso'])) {
                $user->setPhone($data['nameAsso']); 
            }
            if (isset($data['siret'])) {
                $user->setSiret($data['siret']); 
            }
            if (isset($data['website'])) {
                $user->setWebsite($data['website']);
            }
            if (isset($data['image'])) {
                $user->setImage($data['image']);
            }
            if (isset($data['register_date'])) {
                $user->setRegisterDate(new DateTime(date("Y-m-d")));
            }
            if (isset($data['roles'])) {
                $user->setRoles($user->getRoles());
            }
            if (isset($data['gdpr'])) {
                $user->setGdpr(new DateTime(date("Y-m-d")));
            }
    

            $errors = $validator->validate($user);
            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[] = $error->getMessage();
                }
                return new JsonResponse(['message' => 'Echec de la modification', 'errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
            }
    
            $entityManager->persist($user);
            $entityManager->flush();
    
            return new JsonResponse([
                'message' => 'Association modifiée avec succès',
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
                    'register_date' => $user->getRegisterDate(),
                    'gdpr' => $user->getGdpr()
                ]
            ], JsonResponse::HTTP_CREATED);
          
    
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
        Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (!isset($data['email']) || !isset($data['password']) || !isset($data['lastname']) || !isset($data['firstname']) || !isset($data['address']) || !isset($data['city']) || !isset($data['postalCode']) || !isset($data['phone']) || !isset($data['nameAsso']) || !isset($data['siret']) || !isset($data['website']) || !isset($data['image'])) {
            return new JsonResponse(['message' => 'Données manquantes'], JsonResponse::HTTP_BAD_REQUEST);
        } else {
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
            $user->setRegisterDate(new DateTime(date("Y-m-d")));
            $user->setGdpr(new DateTime(date("Y-m-d")));   
        }
        
        $userExist = $entityManager->getRepository(User::class)->findOneBy(["email" => $data['email']]);

        if ($userExist) {
            $errorMessages = [];
            return new JsonResponse(['message' => 'Email déjà utilisé', 'errors' => $errorMessages], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['message' => "Echec lors de l'enregistrement", 'errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

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
                'register_date' => $user->getRegisterDate(),
                'gdpr' => $user->getGdpr()
            ]
        ], JsonResponse::HTTP_CREATED);
      
    }

    #[Route('/login', name: '_login', methods: ['POST'])]
    public function login(
        Request $request, 
        EntityManagerInterface $entityManager, 
        UserPasswordHasherInterface $hashedPassword,
        JWTTokenManagerInterface $JWTTokenManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['email']) || !isset($data['password'])) {
            return new JsonResponse(['message' => 'Données manquantes'], JsonResponse::HTTP_BAD_REQUEST);
        }
        $email=($data['email']);
        $password=($data['password']);

        
        $user = $entityManager->getRepository(User::class)->findOneBy(["email" => $email]);

        if (!($user) || !$hashedPassword->isPasswordValid($user, $password)) {
            return new JsonResponse(['message' => 'Identifiants non valides'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $token = $JWTTokenManager->create($user); 

        return new JsonResponse([
            'message' => 'Connexion réussie',
            'token' => $token,
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'address' => $user->getAddress(),
                'city' => $user->getCity(),
                'postalCode' => $user->getPostalCode(),
                'phone' => $user->getPhone(),
                'nameAsso' => $user->getNameAsso(),
                'website' => $user->getWebsite(),
                'image' => $user->getImage(),
                'roles' => $user->getRoles(),
            ]
        ], JsonResponse::HTTP_OK);
    }

    
    #[Route('/logout', name: '_logout', methods: ['POST'])]
    public function logout(): JsonResponse
    {
        return new JsonResponse(['message' => 'Vous êtes déconnecté'], JsonResponse::HTTP_OK);
    }
    

    #[Route('/{id}/delete', name: '_delete', methods: ['DELETE'])]
    public function deletePet(UserRepository $userRepository, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $user = $userRepository->find($id);
        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Association supprimée avec succès'], 200, [], true);
    }
    
}


