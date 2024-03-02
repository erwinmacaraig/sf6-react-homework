<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\StudentClass;
use App\Entity\Homework;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Routing\Attribute\Route;

class SubmissionController extends AbstractController
{

    public function postHomework(Request $request, EntityManagerInterface $entityManager)
    {
        try {
            $data = json_decode($request->getContent(), true);
            $postHomework = new Homework();
            $postHomework->setHomeworkTitle($data['title']);
            $postHomework->setDescription($data['description']);
            $postHomework->setSubmissionDeadline(new \DateTime($data['deadline']));
            $currentDateTime = new \DateTime('now');
            $postHomework->setPostedDate($currentDateTime);
            $postHomework->setStudentClass($entityManager->getRepository(StudentClass::class)->find($data['student_class']));
            $postHomework->setUser($entityManager->getRepository(User::class)->find($data['user']));
            $entityManager->persist($postHomework);
            $entityManager->flush();
            return $this->json([
                "message" => "SUCCESS"
            ]);
        } catch (\Exception $e) {
            return $this->json([
                "message" => $e->getMessage()
            ], 400);
        }
    }

    public function isolateHomework(Request $request, EntityManagerInterface $entityManager)
    {
        try {
            $data = json_decode($request->getContent(), true);

            $hwRecord = $entityManager->getRepository(Homework::class)->getHomeworkRecord($data['homeworkId']);

            return $this->json($hwRecord[0], 200);
        } catch (\Exception $e) {
            return $this->json(["message" => $e->getMessage()], 400);
        }
    }

    public function getAllActiveHomework(Request $request, EntityManagerInterface $entityManager)
    {
        try {
            $data = json_decode($request->getContent(), true);
            $hw = $entityManager->getRepository(User::class)->listClassHomework($data['user']);

            return $this->json($hw, 200, [
                'Access-Control-Allow-Origin' => 'http://localhost:8000'
            ]);
        } catch (\Exception $e) {
            return $this->json([
                "message" => $e->getMessage()
            ], 400);
        }
    }

    public function handleFileUpload(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

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
