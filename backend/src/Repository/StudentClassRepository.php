<?php

namespace App\Repository;

use App\Entity\StudentClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudentClass>
 *
 * @method StudentClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentClass[]    findAll()
 * @method StudentClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentClassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentClass::class);
    }

    //    /**
    //     * @return StudentClass[] Returns an array of StudentClass objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?StudentClass
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function listStudentClasses()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * FROM student_class';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();
        return $result->fetchAllAssociative();
    }
}
