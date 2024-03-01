<?php

namespace App\Repository;

use App\Entity\Homework;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Homework>
 *
 * @method Homework|null find($id, $lockMode = null, $lockVersion = null)
 * @method Homework|null findOneBy(array $criteria, array $orderBy = null)
 * @method Homework[]    findAll()
 * @method Homework[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Homework::class);
    }

    //    /**
    //     * @return Homework[] Returns an array of Homework objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Homework
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function getHomeworkRecord($homeworkId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT homework.*, user.id, user.first_name, user.family_name, student_class.class_title FROM homework INNER JOIN user
ON homework.user_id =user.id
INNER JOIN user_role ON user_role.user_id = user.id
INNER JOIN role ON role.id = user_role.role_id 
INNER JOIN student_class ON student_class.id = homework.student_class_id
  WHERE 
  role = 'ROLE_TEACHER' AND
  homework.id = ?";

        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery([$homeworkId]);
        return $result->fetchAllAssociative();
    }
}
