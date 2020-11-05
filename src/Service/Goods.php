<?php


namespace SimpleRest\Service;


use Doctrine\ORM\EntityManager;
use Faker\Generator;
use SimpleRest\Entity\Goods as GoodsEntity;
use SimpleRest\Repository\GoodsRepository;

class Goods
{

    private $entityManager;

    private $faker;

    public function __construct(EntityManager $entityManager, Generator $faker)
    {
        $this->entityManager = $entityManager;
        $this->faker = $faker;
    }

    public function generateGoods():void
    {
        for ($i = 0; $i < 20; $i++) {
            $goods = new GoodsEntity();
            $goods->setName($this->faker->name);
            $goods->setPrice($this->faker->randomFloat(2, 1, 300));
            $this->entityManager->persist($goods);
        }

        $this->entityManager->beginTransaction();
        try {
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }

    }

    public function getAllGoods(?int $page = 1, ?int $count = 20):array
    {
        $goodsRepository = $this->entityManager->getRepository(GoodsEntity::class);
        return $goodsRepository->getAllGoods($page, $count);
    }
}