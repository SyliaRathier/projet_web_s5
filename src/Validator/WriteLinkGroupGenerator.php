<?php

namespace App\Validator;

use ApiPlatform\Symfony\Validator\ValidationGroupsGeneratorInterface;
use App\Entity\Ingredient;
use App\Entity\Materiel;
use App\Entity\Utilisateur;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Constraints\GroupSequence;

class WriteLinkGroupGenerator implements ValidationGroupsGeneratorInterface
{
    public function __construct(
        private Security $security
    )
    {
    }
    public function __invoke($object): array|GroupSequence
    {
        assert($object instanceof Ingredient || $object instanceof Materiel);
        $user = $this->security->getUser();
        $group = 'write';
        $user instanceof Utilisateur && $user->isPremium() ? $group = 'premium': $group = 'write';
        return ['Default', $group];
    }
}