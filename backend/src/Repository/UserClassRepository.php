<?php

namespace App\Repository;

use App\Entity\UserClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserClass>
 *
 * @method UserClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserClass[]    findAll()
 * @method UserClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserClassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserClass::class);
    }

    //    /**
    //     * @return UserClass[] Returns an array of UserClass objects
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

    //    public function findOneBySomeField($value): ?UserClass
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function listUserClass($userId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT student_class.* FROM student_class INNER JOIN user_class ON student_class.id = user_class.student_class_id  WHERE user_class.user_id = ?;';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery([$userId]);
        return $result->fetchAllAssociative();
    }
}
