<?php

namespace App\EventListener;

use App\Entity\Utilisateur;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener
{
    /**
     * @param JWTCreatedEvent $event
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();

        // Récupérer l'utilisateur
        $user = $event->getUser();

        // Ajouter des données supplémentaires au payload
        $payload['id'] = $user->getId();
        $payload['adresseMail'] = $user->getAdresseEmail();
        $payload['premium'] = $user->isPremium(); // Supposons que premium soit un booléen

        $event->setData($payload);
    }
}