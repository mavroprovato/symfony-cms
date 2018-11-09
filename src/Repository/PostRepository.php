<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * The post repository
 */
class PostRepository extends ServiceEntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Return the number of posts that where published per month.
     *
     * @return mixed The number of posts that where published per month.
     */
    public function countByMonth()
    {
        return $this->createQueryBuilder('c')
            ->select('YEAR(c.publishedAt) AS year, MONTH(c.publishedAt) AS month, COUNT(c) as count')
            ->groupBy('year, month')
            ->addOrderBy('year', 'DESC')
            ->addOrderBy('month', 'DESC')
            ->getQuery()
            ->getResult('CountByMonthHydrator');
    }
}