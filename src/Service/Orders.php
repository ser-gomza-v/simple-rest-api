<?php

namespace SimpleRest\Service;

use Doctrine\ORM\EntityManager;
use SimpleRest\Entity\Goods as GoodsEntity;
use SimpleRest\Entity\Orders as OrderEntity;

class Orders
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function makeOrder(array $goodsIds):OrderEntity
    {
        if (empty($goodsIds)) {
            throw new \Exception('Goods array is empty');
        }

        $order = new OrderEntity();
        $order->setStatus(OrderEntity::ORDER_NEW);

        foreach ($goodsIds as $goodsId) {
            $order->addGoods(
                $this->entityManager->find(GoodsEntity::class, $goodsId)
            );
        }

        $this->entityManager->beginTransaction();
        try {
            $this->entityManager->persist($order);
            $this->entityManager->flush();
            $this->entityManager->commit();
            return $order;
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    public function getAllOrders(?int $page = 1, ?int $count = 20):array
    {
        $ordersRepository = $this->entityManager->getRepository(OrderEntity::class);
        return $ordersRepository->getAllOrders($page, $count);
    }

    public function payOrder(int $orderId)
    {
        $order = $this->entityManager->find(OrderEntity::class, $orderId);
        if ($result = $this->sendRequest() != '200') {
            throw new \Exception('Error sending request '.$result);
        }

        if ($order->getStatus() == OrderEntity::ORDER_PAID) {
            return $order;
        }

        $order->setStatus(OrderEntity::ORDER_PAID);

        $this->entityManager->beginTransaction();
        try{
            $this->entityManager->persist($order);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
        }

        return $order;
    }

    public function sendRequest()
    {
        file_get_contents('https://ya.ru', false);

        $status_line = array_shift($http_response_header);
        if (!preg_match('/^(\w+)\/(\d+\.\d+) (\d+) (.+?)$/', $status_line, $matches)) {
            throw new \Exception("Invalid status: {$status_line}");
        }

        return $matches[3];
    }

}