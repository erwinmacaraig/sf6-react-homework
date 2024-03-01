<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
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

    public function listClassHomework($userId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT
                homework.id, 
                homework.student_class_id,
                homework.description,
                homework.submission_deadline,
                homework.posted_date,
                homework.homework_title 
            FROM 
                homework
            INNER JOIN
                user_class 
            ON
                homework.student_class_id = user_class.student_class_id
            WHERE
                user_class.user_id = ?
            AND
                homework.submission_deadline >= current_date();';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery([$userId]);
        return $result->fetchAllAssociative();
    }
}
