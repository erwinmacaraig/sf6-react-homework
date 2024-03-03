<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
    public function loadUserByIdentifier(string $usernameOrEmail): ?User
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT u
                FROM App\Entity\User u
                WHERE u.email = :query'
        )
            ->setParameter('query', $usernameOrEmail)
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function listClassHomework($username, $role)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = null;
        if ($role == 'ROLE_TEACHER') {
            $sql = "
                SELECT
                    homework.id, 
                    homework.student_class_id,
                    homework.description,
                    homework.submission_deadline,
                    homework.posted_date,
                    homework.homework_title,
                    student_class.class_title 
                FROM 
                    homework
                INNER JOIN
                    user_class 
                ON
                    homework.student_class_id = user_class.student_class_id
                INNER JOIN
					student_class 
				ON
					student_class.id = homework.student_class_id
    			INNER JOIN
    				user ON user.id = user_class.user_id
                WHERE
                    user.username = ?
                AND
                    JSON_EXTRACT(roles, '$[0]') = 'ROLE_TEACHER'
                ORDER BY
                    student_class.class_title DESC, homework.posted_date DESC;";
        } else {
            $sql = "
                SELECT
                    homework.id, 
                    homework.student_class_id,
                    homework.description,
                    homework.submission_deadline,
                    homework.posted_date,
                    homework.homework_title,
                    student_class.class_title 
                FROM 
                    homework
                INNER JOIN
                    user_class 
                ON
                    homework.student_class_id = user_class.student_class_id
                INNER JOIN
					student_class 
				ON
					student_class.id = homework.student_class_id
    			INNER JOIN
    				user ON user.id = user_class.user_id
                WHERE
                    user.username = ?
                AND
                    homework.submission_deadline >= current_date()
                AND
                    JSON_EXTRACT(roles, '$[0]') = 'ROLE_STUDENT'
                ORDER BY
                    student_class.class_title DESC, homework.posted_date DESC;";
        }
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery([$username]);
        return $result->fetchAllAssociative();
    }
}
