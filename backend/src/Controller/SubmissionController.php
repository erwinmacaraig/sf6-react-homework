<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\Routing\Attribute\Route;

class SubmissionController extends AbstractController
{
    public function handleFileUpload(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        dump($data);

        return $this->json([
            "message" => "OK",
            "items" => count($_FILES)
        ]);
    }

    private function getUploadDir()
    {
        return $this->getParameter('uploads_dir');
    }
}
