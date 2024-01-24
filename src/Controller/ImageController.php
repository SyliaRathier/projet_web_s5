<?php

namespace App\Controller;

use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route(path: 'image/{type}/{img}', name: 'image', methods: ['GET'])]
    public function image(string $type, string $img): BinaryFileResponse
    {
        $filePath = $this->getParameter('kernel.project_dir') . '/public/img/' .$type.'/'. $img;

        // Create a BinaryFileResponse for the file
        $response = new BinaryFileResponse($filePath);

        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $img);

        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/jpeg');

        return $response;
    }
}