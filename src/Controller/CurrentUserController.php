<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


#[AsController]
class CurrentUserController extends AbstractController
{
    // public function __construct(private readonly SerializerInterface $serializer)
    // {
    // }

    // #[Route('/api/dataUser', name: 'app_data_user', methods: ['GET'])]
    // public function __invoke(): JsonResponse
    // {
    //     $user = $this->serializer->serialize($this->getUser(), 'json', ['groups' => 'read']);
    //     return new JsonResponse(json_decode($user));
    // }
}
