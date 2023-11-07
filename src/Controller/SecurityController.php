<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Controller\JsonResponse;
use App\Entity\User as EntityUser;
use Symfony\Component\Security\Core\User;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/api/login_check', name: 'api_login', methods: ['POST'])]
    public function api_login(EntityUser $user1)
    {
        $user = $this->getUser();
        return $this->json([
            'userIdentifier' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
            // 'id' => $user->getId(),
            // 'email' => $user->getEmail(),
        ]);
    }

    // ---------------TEST 1--------------

    // #[Route(path: '/api/login', name: 'api_login', methods: ['POST'])]
    // public function api_login(): JsonResponse
    // {
    //     $user = $this->getUser();
    //     return new Response([
    //         'email' => $user->getEmail(),
    //         'roles' => $user->getRoles()
    //     ]);
    // }

    // ---------------TEST 2--------------


    // #[Route(path: '/api/api_login', name: 'api_login', methods: ['POST'])]
    // public function api_login(EntityManagerInterface $entityManager)
    // {
    //     if ($this->getUser()) {

    //         return $this->redirectToRoute('home');
    //     }
    //     $userId = $this->getUser()->getUserIdentifier();

    //     $user = $entityManager->getRepository(User::class)->find($userId);

    //     if ($user && !$user->getStatus()) {
    //         throw new CustomUserMessageAuthenticationException('Votre compte a été suspendu.');
    //     }

    //     $user = $this->getUser();
    //     return $this->json([
    //         'userIdentifier' => $user->getUserIdentifier(),
    //         'roles' => $user->getRoles()
    //     ]);
    // }



}
