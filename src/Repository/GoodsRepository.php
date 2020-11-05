<?php


namespace SimpleRest\Repository;


use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityRepository;
use SimpleRest\Entity\Goods;

class GoodsRepository extends EntityRepository
{
    public function getAllGoods(?int $page = 1, ?int $count = 20):array
    {
        $queryBuilder = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $tableName = $this->getEntityManager()->getClassMetadata(Goods::class)->getTableName();

        $data = $queryBuilder
            ->select('g.id', 'g.name', 'g.price')
            ->from($tableName, 'g')
            ->orderBy('g.id', 'ASC')
            ->setFirstResult(($page*$count)-$count)
            ->setMaxResults($count);

        return $data->execute()->fetchAll(FetchMode::ASSOCIATIVE);
    }
}