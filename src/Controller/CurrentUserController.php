<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


#[AsController]
#[Route('/api')]

class CurrentUserController extends AbstractController
{

    // private Security $security;
    // private SerializerInterface $serializer;
    // private LoggerInterface $logger;

    public function __construct(private readonly SerializerInterface $serializer)
    {
        // $this->security = $security;
        // $this->serializer = $serializer;
        // $this->logger = $logger;
    }

   

    #[Route('/me', name: 'get_me', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $user = $this->serializer->serialize($this->getUser(), 'json', ['groups' => 'user:read']);
        return new JsonResponse(json_decode($user));
    }


     // METHODE 1

    // #[Route('/me', name: 'get_me', methods: ['GET'])]
    // public function __invoke(JWTCreatedEvent $event): JsonResponse
    // {
    //     $user = $event->getUser();
    //     $userId = $user->getUserIdentifier();
    //     $serializedUser = $this->serializer->serialize($userId, 'json');
    //     $serializedUser = $this->serializer->serialize($userId, 'json', ['groups' => 'read']);

    //     return new JsonResponse($serializedUser, 200, [], true);
    //     return new JsonResponse(json_decode($userId));
    // }

    // public function getCurrentUser(): JsonResponse
    // {

    //     try {
    //         $user = $this->security->getUser();
    //         $serializedUser = $this->serializer->serialize($user, 'json', ['groups' => 'read']);

    //         // Ajouter un log pour vérifier les données sérialisées
    //         $this->logger->info('Données sérialisées de l\'utilisateur : ' . $serializedUser);

    //         return new JsonResponse(json_decode($serializedUser));
    //     } catch (\Exception $e) {
    //         // Log de l'erreur
    //         $this->logger->error('Erreur lors de la récupération des données utilisateur : ' . $e->getMessage());

    //         // Réponse d'erreur
    //         return new JsonResponse(['error' => 'Une erreur s\'est produite lors de la récupération des données utilisateur.'], 500);
    //     }
    // }

    // METHODE 2

    // #[Route('/api/dataUser', name: 'app_data_user', methods: ['GET'])]
    // public function getUser(): ?User
    // {
    //     $token = $this->tokenStorage->getToken();

    //     if (!$token) {
    //         return null;
    //     }

    //     $user = $token->getUser();

    //     if (!$user instanceof User) {
    //         return null;
    //     }

    //     return $user;
    // }

    // METHODE 3

    // #[Route('/api/dataUser', name: 'app_data_user', methods: ['GET'])]
    // public function __invoke(): JsonResponse
    // {
    //     $user = $this->getUser();
    //     $serializedUser = $this->serializer->serialize($user, 'json', ['groups' => 'read']);

    //     return new JsonResponse($serializedUser, 200, [], true);
    //     // return new JsonResponse(json_decode($serializedUser));
    // }
}
