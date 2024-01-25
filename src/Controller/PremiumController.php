<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use App\Service\PaymentHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PremiumController extends AbstractController
{
    //#[IsGranted(new Expression("is_granted('ROLE_USER') and user.isPremium() == false"))]
    #[Route('/premium', name: 'premiumInfos', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }

    //#[IsGranted(new Expression("is_granted('ROLE_USER') and user.isPremium() == false"))]
    #[Route('/premium/checkout/user/{id}', name:'premiumCheckout', methods: ["GET"])]
    public function premiumCheckout(UtilisateurRepository $utilisateurRepository ,PaymentHandlerInterface $paymentHandler, String $id,){
        $utilisateur = $utilisateurRepository->find($id);
        //var_dump($utilisateur);
        //echo 'echo6 ' ;
        var_dump($id);
        return $this->redirect(
            $paymentHandler->getPremiumCheckoutUrlFor($utilisateur)
        );

    }

    #[Route('/premium/checkout/confirm', name:'premiumCheckoutConfirm', methods: ['GET'])]
    public function premiumCheckoutConfirm(Request $request, PaymentHandlerInterface $paymentHandler, RouterInterface $router){
        $param = $request->get('session_id');
        $res = $paymentHandler->checkPaymentStatus($param);
        echo 'echo7';
        if($res){
            $this->addFlash('success', 'Paiement confirmé. Vous êtes maintenant membre premium !');
        }
        else{
            $this->addFlash('error', 'Une erreur est survenue lors du paiement. Veuillez réessayer');
        }
        echo 'echo10';
        return $this->render('base.html.twig');

    }
}
