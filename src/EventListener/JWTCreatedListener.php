<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class JWTCreatedListener
{

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        $user = $event->getUser();
        $userId = $user->getUserIdentifier();

        // Ajoutez l'ID de l'utilisateur au payload du JWT
        $payload = $event->getData();
        $payload['id'] = $userId;

        // Vous pouvez également ajouter d'autres informations si nécessaire

        $event->setData($payload);

        // Modifiez les en-têtes du JWT si nécessaire
        $header = $event->getHeader();
        $header['cty'] = 'JWT';

        $event->setHeader($header);
    }
}
