<?php

namespace App\Repository;

use App\Entity\Buyer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BuyerRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Buyer::class);
    }

    public function getBuyers(string $searchQuery, int $limit)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('b')
            ->from($this->_entityName, 'b');

        $expr = $qb->expr()->orX($qb->expr()->like('b.name', ':searchQuery'),
            $qb->expr()->like('b.nip', ':searchQuery'));
        $qb->where($expr)
            ->setParameter('searchQuery', $searchQuery.'%')
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}