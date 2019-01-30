<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findPosts($page, $nbPerPage)
    {
        $query=$this->createQueryBuilder('p')
            ->leftJoin('p.image', 'i')
            ->addSelect('i')
            ->leftJoin('p.categories', 'c')
            ->addSelect('c')
            ->orderBy('p.date', 'DESC')
            ->getQuery();
        $query
            ->setFirstResult(($page-1)*$nbPerPage)
            ->setMaxResults($nbPerPage);
        return new Paginator($query, true);
    }

    public function getAllParentCategoryPosts($value)
    {
        return $this->createQueryBuilder('p')
        ->leftJoin('p.categories', 'c')
        ->where('category.name = :$value')
        ->addSelect('c')
        ->orderBy('p.date', 'DESC')
        ->getQuery()
        ->getResult()
        ;
    }
    /*
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM App:Post p ORDER BY p.title ASC'
            )
            ->getResult();
    }
    */
    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

