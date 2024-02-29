<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\StudentClass;
use App\Entity\Role;
use App\Entity\UserRole;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadRole($manager);
        $this->loadUserRole($manager);
        $this->loadStudentClass($manager);
        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setFirstName('Erwin');
        $user->setFamilyName('Mcraig');
        $user->setEmail('erwin@test.com');
        $user->setPasswordHash('PlainPassword');
        $this->addReference('erwin', $user);
        $manager->persist($user);


        $user2 = new User();
        $user2->setFirstName('Gel');
        $user2->setFamilyName('Mcraig');
        $user2->setEmail('gel@test.com');
        $user2->setPasswordHash('PlainPassword');
        $this->addReference('gel', $user2);
        $manager->persist($user2);


        $user3 = new User();
        $user3->setFirstName('Bam');
        $user3->setFamilyName('Bi');
        $user3->setEmail('bam_bi@test.com');
        $user3->setPasswordHash('PlainPassword');
        $this->addReference('bam', $user3);
        $manager->persist($user3);


        $user4 = new User();
        $user4->setFirstName('Dy');
        $user4->setFamilyName('Lan');
        $user4->setEmail('dy_lan@test.com');
        $user4->setPasswordHash('PlainPassword');
        $this->addReference('dylan', $user4);
        $manager->persist($user4);

        $manager->flush();
    }

    public function loadStudentClass(ObjectManager $manager)
    {
        $studentClass = new StudentClass();
        $studentClass->setClassTitle('PHP Programming');
        $manager->persist($studentClass);
        $manager->flush();

        $studentClass = new StudentClass();
        $studentClass->setClassTitle('Frontend Development with ReactJS');
        $manager->persist($studentClass);
        $manager->flush();

        $studentClass = new StudentClass();
        $studentClass->setClassTitle('Java 101');
        $manager->persist($studentClass);
        $manager->flush();
    }

    public function loadRole(ObjectManager $manager)
    {
        $roleTeacher = new Role();
        $roleTeacher->setRole('ROLE_TEACHER');
        $roleTeacher->setRoleTitle('Teacher');
        $this->addReference('teacher_role', $roleTeacher);

        $manager->persist($roleTeacher);

        $roleStudent = new Role();
        $roleStudent->setRole('ROLE_STUDENT');
        $roleStudent->setRoleTitle('Student');
        $this->addReference('student_role', $roleStudent);
        $manager->persist($roleStudent);

        $manager->flush();
    }

    public function loadUserRole($manager)
    {
        $user1 = $this->getReference('erwin');
        $user2 = $this->getReference('gel');
        $user3 = $this->getReference('bam');
        $user4 = $this->getReference('dylan');
        $teacher = $this->getReference('teacher_role');
        $student = $this->getReference('student_role');

        $userRole = new UserRole();
        $userRole->setUser($user1);
        $userRole->setRole($teacher);
        $manager->persist($userRole);
        $manager->flush();

        $userRole = new UserRole();
        $userRole->setUser($user2);
        $userRole->setRole($teacher);
        $manager->persist($userRole);
        $manager->flush();

        $userRole = new UserRole();
        $userRole->setUser($user3);
        $userRole->setRole($student);
        $manager->persist($userRole);
        $manager->flush();

        $userRole = new UserRole();
        $userRole->setUser($user4);
        $userRole->setRole($student);
        $manager->persist($userRole);
        $manager->flush();
    }
}
