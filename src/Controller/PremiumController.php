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
        return $this->redirect(
            $paymentHandler->getPremiumCheckoutUrlFor($utilisateur)
        );

    }

    #[Route('/premium/checkout/confirm', name:'premiumCheckoutConfirm', methods: ['GET'])]
    public function premiumCheckoutConfirm(Request $request, PaymentHandlerInterface $paymentHandler, RouterInterface $router){
        $param = $request->get('session_id');
        //echo $param;
        $res = $paymentHandler->checkPaymentStatus($param);
        if($res){
            $this->addFlash('success', 'Paiement confirmé. Vous êtes maintenant membre premium !');
            //return new Response(null, 200, ['Location' => 'http://127.0.0.1:5173/creerIngredient']);
            return $this->redirect('http://localhost:5173/connexion');
        }
        else{
            $this->addFlash('error', 'Une erreur est survenue lors du paiement. Veuillez réessayer');
            return new Response(null, 402, ['Location' => 'http://127.0.0.1:5173/premium']);
        }


    }
}
