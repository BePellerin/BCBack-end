<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
#[Route('/api')]
// #[AsController]
class CurrentUserController extends AbstractController
{

    private Security $security;
    private SerializerInterface $serializer;
    private LoggerInterface $logger;
    public function __construct(Security $security, SerializerInterface$serializer, LoggerInterface $logger)
    {
        $this->security = $security;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    // METHODE 1

    #[Route('/me', name: 'get_me', methods: ['GET'])]
    public function getCurrentUser(): JsonResponse
    {
        
        try {
            $user = $this->security->getUser();
            $serializedUser = $this->serializer->serialize($user, 'json', ['groups' => 'read']);

            // Ajouter un log pour vérifier les données sérialisées
            $this->logger->info('Données sérialisées de l\'utilisateur : ' . $serializedUser);

            return new JsonResponse(json_decode($serializedUser));
        } catch (\Exception $e) {
            // Log de l'erreur
            $this->logger->error('Erreur lors de la récupération des données utilisateur : ' . $e->getMessage());

            // Réponse d'erreur
            return new JsonResponse(['error' => 'Une erreur s\'est produite lors de la récupération des données utilisateur.'], 500);
        }
    }
    
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
