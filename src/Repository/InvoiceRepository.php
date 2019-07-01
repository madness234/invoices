<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class InvoiceRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Invoice::class);
    }

    public function getInvoiceCount(int $year, int $month)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('count(i)')
            ->from($this->_entityName, 'i')
            ->where('YEAR(i.issueDate) = :year')
            ->andWhere('MONTH(i.issueDate) = :month')
            ->setParameter('year', $year)
            ->setParameter('month', $month);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getInvoices(int $offset, int $limit)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('i')
            ->from($this->_entityName, 'i')
            ->orderBy('i.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    public function countInvoices()
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('count(i)')
            ->from($this->_entityName, 'i');

        return $qb->getQuery()->getSingleScalarResult();
    }
}