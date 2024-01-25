<?php

namespace App\Service;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\StripeClient;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

use App\Entity\Utilisateur;

class PaymentHandler implements PaymentHandlerInterface
{

    public function __construct(
        //Injection du paramètre dossier_photo_profil
        #[Autowire('%api_key%')] private string $apiKey,
        #[Autowire('%premium_price%')] private string $premiumPrice,
        #[Autowire('%signature_secrete%')] private string $signatureSecrete,
        private RouterInterface $router,
        private UtilisateurRepository $utilisateurRepository,
        private EntityManagerInterface $entityManager

    ){}

    //Génère et renvoie un lien vers Stripe afin de finaliser l'achat du statut Premium pour l'utilisateur passé en paramètre.
    public function getPremiumCheckoutUrlFor(Utilisateur $utilisateur)  : string
    {
        var_dump($utilisateur);
        echo $utilisateur->getId();
        $paymentData = [
            'mode' => 'payment',
            'payment_intent_data' => ['capture_method' => 'manual', 'receipt_email' => $utilisateur->getAdresseEmail()],
            'customer_email' => $utilisateur->getAdresseEmail(),
            'success_url' => $this->router->generate('premiumCheckoutConfirm', [],UrlGeneratorInterface::ABSOLUTE_URL) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $this->router->generate('premiumInfos',[], UrlGeneratorInterface::ABSOLUTE_URL),
            "metadata" => ["data" => $utilisateur->getId(), "student_token" => 'Sylia'],
            "line_items" => [
                [
                    "price_data" => [
                        "currency" => "eur",
                        "product_data" => ["name" => "The Feed Premium"],
                        "unit_amount" => $this->premiumPrice * 100
                    ],
                    "quantity" => 1

                ]
            ]
        ];
        //Stripe::setApiKey($this->apiKey);
        $stripe = new StripeClient($this->apiKey);
        $stripeSession = $stripe->checkout->sessions->create($paymentData);
        //$stripeSession = Session::create($paymentData);
        $url = $stripeSession->url;
        var_dump($url);
        return $url;

    }

    public function handlePaymentPremium($session) : void {
        $metadata = $session["metadata"];
        if(!isset($metadata["data"])) {
            throw new \Exception("dataExemple manquant...");
        }
        $id = $metadata["data"];
        $utilisateur = $this->utilisateurRepository->find($id);

        $paymentIntent = $session["payment_intent"];
        $stripe = new StripeClient($this->apiKey);
        $paymentCapture = $stripe->paymentIntents->capture($paymentIntent, []);
        if($paymentCapture==null || $paymentCapture["status"] != "succeeded") {
            $stripe->paymentIntents->cancel($paymentIntent);
            throw new \Exception("Le paiement n'a pas pu être complété...");
        }
        if(!isset($metadata["student_token"]) || $metadata["student_token"] !== "Sylia") {
            $stripe->paymentIntents->cancel($paymentIntent);
            throw new \Exception("Requête d'un autre étudiant...");
        }


        $utilisateur->setPremium(true);
        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();
    }

    public function checkPaymentStatus($sessionId) : bool {
        echo 'echo8';
        $stripe = new StripeClient($this->apiKey);
        $session = $stripe->checkout->sessions->retrieve($sessionId);
        $paymentIntentId = $session->payment_intent;
        $paymentIntent = $stripe->paymentIntents->retrieve($paymentIntentId);
        $status = $paymentIntent->status;
        $capture= false;
        if($status == "succeeded"){
            $capture=true;
            echo 'echo9';
        }
        echo $capture;
        return $capture;

    }

}