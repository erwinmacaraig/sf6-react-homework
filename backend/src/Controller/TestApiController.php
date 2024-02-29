<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestApiController extends AbstractController
{
    #[Route('/test/api', name: 'app_test_api')]
    public function index(): Response
    {
        return $this->render('test_api/index.html.twig', [
            'controller_name' => 'TestApiController',
        ]);
    }

    #[Route('/api', name: 'app_api', methods: ['get'])]
    public function test(): JsonResponse
    {
        return $this->json([
            "message" => "success"
        ]);
    }

    public function api(): JsonResponse
    {
        return $this->json([
            "result" => "OK!"
        ]);
    }
}
