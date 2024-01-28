<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Ingredient;
use App\Entity\Materiel;
use App\Entity\Recette;
use App\Entity\Utilisateur;
use App\Repository\MaterielRepository;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthorProcessor implements ProcessorInterface
{


    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')] private ProcessorInterface $persistProcessor,
        private Security $security,
    )
    {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $user = $this->security->getUser();

        $this->setAuthor($data, $user);
        // Handle the state
        $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }


    public function setAuthor(Object $obj, mixed $author): void
    {
        if ($author == null) return;
        if ($author instanceof Utilisateur && $obj instanceof Materiel || $obj instanceof Ingredient || $obj instanceof Recette){
            $obj->setUtilisateur($author);
        }
    }


}
