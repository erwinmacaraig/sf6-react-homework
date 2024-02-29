<?php

namespace App\Controller;

use App\Entity\StudentClass;
use App\Repository\StudentClassRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;


class UserController extends AbstractController
{
    public function getStudentClassListing(StudentClassRepository $studentClassRepo): JsonResponse
    {
        $list = $studentClassRepo->listStudentClasses();
        return $this->json($list);
    }
}
