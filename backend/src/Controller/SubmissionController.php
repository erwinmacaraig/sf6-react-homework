<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use App\Entity\StudentClass;
use App\Entity\Homework;
use App\Entity\Submission;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Routing\Attribute\Route;

class SubmissionController extends AbstractController
{

    public function postHomework(Request $request, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
    {
        try {
            $decodedJwtToken = $jwtManager->decode($tokenStorageInterface->getToken());
            $data = json_decode($request->getContent(), true);
            $postHomework = new Homework();
            $postHomework->setHomeworkTitle($data['title']);
            $postHomework->setDescription($data['description']);
            $postHomework->setSubmissionDeadline(new \DateTime($data['deadline']));
            $currentDateTime = new \DateTime('now');
            $postHomework->setPostedDate($currentDateTime);
            $postHomework->setStudentClass($entityManager->getRepository(StudentClass::class)->find($data['student_class']));
            $user = $entityManager->getRepository(User::class)->findOneBy(['username' => $decodedJwtToken['username']]);

            $postHomework->setUser($user);
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
            if (count($hwRecord) == 0) {
                return $this->json([], 404);
            }

            return $this->json($hwRecord[0], 200);
        } catch (\Exception $e) {
            return $this->json(["message" => $e->getMessage()], 400);
        }
    }

    public function getAllActiveHomework(Request $request, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
    {
        $decodedJwtToken = $jwtManager->decode($tokenStorageInterface->getToken());
        try {
            $data = json_decode($request->getContent(), true);
            $hw = $entityManager->getRepository(User::class)->listClassHomework($decodedJwtToken['username']);
            return $this->json($hw, 200);
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

    public function processHomeworkSubmission(Request $request, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager): JsonResponse
    {
        $decodedJwtToken = $jwtManager->decode($tokenStorageInterface->getToken());
        try {
            $data = json_decode($request->getContent(), true);
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $decodedJwtToken['username']]);
            $homeworkObj = $entityManager->getRepository(Homework::class)->find($data['homework_id']);

            $submissionObject = new Submission();
            $submissionObject->setHomework($homeworkObj);
            $submissionObject->setUser($user);
            $submissionObject->setDateSubmitted($data['date_submitted']);
            $submissionObject->setRemarks($data['remarks']);
            $submissionObject->setTitle($data['title']);
            $entityManager->persist($submissionObject);
            $entityManager->flush();

            return $this->json([
                "status" => "SUCCESS"
            ], 200);
        } catch (\Exception $e) {
            return $this->json([
                "message" => $e->getMessage()
            ], 400);
        }
    }

    private function getUploadDir()
    {
        return $this->getParameter('uploads_dir');
    }
}
