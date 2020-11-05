<?php


namespace SimpleRest\Repository;


use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityRepository;
use SimpleRest\Entity\Orders;

class OrdersRepository extends EntityRepository
{
    public function getAllOrders(?int $page = 1, ?int $count = 20):array
    {
        $queryBuilder = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $tableName = $this->getEntityManager()->getClassMetadata(Orders::class)->getTableName();

        $data = $queryBuilder
            ->select('o.id', 'o.status')
            ->from($tableName, 'o')
            ->orderBy('o.id', 'ASC')
            ->setFirstResult(($page*$count)-$count)
            ->setMaxResults($count);

        return $data->execute()->fetchAll(FetchMode::ASSOCIATIVE);
    }
}