<?php

namespace App\Security;

use App\Entity\Materiel;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class MaterielVoter extends Voter
{
    public const DELETE = 'MATERIEL_DELETE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // Je vote si la permission vérifiée est PUBLICATION_DELETE et que $subject est une instance de la classe Publication.
        return $attribute === self::DELETE && $subject instanceof Materiel;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Vérifie si l'utilisateur est l'auteur de la publication ou a le rôle ROLE_ADMIN
        if ($attribute === self::DELETE && $subject instanceof Materiel) {
            return $this->security->isGranted('ROLE_ADMIN') || ($user !== null && $subject->getUtilisateur() === $user);
        }

        return false;
    }
}