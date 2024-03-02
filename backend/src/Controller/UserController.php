<?php

namespace App\Controller;

use App\Entity\StudentClass;
use App\Entity\User;

use App\Entity\Role;
use App\Entity\UserClass;

use App\Repository\StudentClassRepository;
use App\Repository\UserClassRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UserController extends AbstractController
{
    public function getStudentClassListing(StudentClassRepository $studentClassRepo): JsonResponse
    {
        $list = $studentClassRepo->listStudentClasses();
        return $this->json($list);
    }

    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);


            $user = new User();
            $user->setFirstName($data['firstName']);
            $user->setFamilyName($data['familyName']);
            $user->setEmail($data['email']);
            $user->setUsername($data['email']);

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $data['password']
            );
            $user->setPasswordHash($hashedPassword);
            $user->setRoles(['ROLE_STUDENT']);
            $entityManager->persist($user);
            $availedClasses = $data['classes'];
            for ($x = 0; $x < count($availedClasses); $x++) {
                $enrolledClass = new UserClass();
                $enrolledClass->setUser($user);
                $enrolledClass->setStudentClass(
                    $entityManager->getRepository(StudentClass::class)->find($availedClasses[$x])
                );
                $entityManager->persist($enrolledClass);
            }

            $entityManager->flush();


            return $this->json([
                "message" => "SUCCESS"
            ]);
        } catch (Exception $e) {
            return $this->json([
                "error" => $e->getMessage()
            ], 400);
        }
    }

    public function getUserClass(Request $request, EntityManagerInterface $entityManager)
    {
        try {
            $userId = $request->query->get('user');
            $userRegistereClasses = $entityManager->getRepository(UserClass::class)->listUserClass($userId);

            return $this->json($userRegistereClasses, 200);
        } catch (\Exception $e) {
            return $this->json([
                "message" => $e->getMessage()
            ], 400);
        }
    }
}
