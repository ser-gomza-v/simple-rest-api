<?php


namespace SimpleRest\Controller;


use SimpleRest\Service\Orders;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrdersController
{
    private $orderService;

    public function __construct(Orders $orderService)
    {
        $this->orderService = $orderService;
    }

    public function makeAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $order = $this->orderService->makeOrder($data['data']['goods']);

        $response = new JsonResponse([
            'data' => [
                'order id' => $order->getId(),
                'paid' => $order->getStatus()
            ]
        ]);

        return $response;
    }

    public function payAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $order = $this->orderService->payOrder($data['data']['order']);

        $response = new JsonResponse([
            'data' => [
                'order id' => $order->getId(),
                'paid' => $order->getStatus()
            ]
        ]);

        return $response;
    }

    public function allAction(Request $request)
    {
        $page = $request->get('page');
        $count = $request->get('count');

        $allOrders = $this->orderService->getAllOrders($page, $count);

        $response = new JsonResponse([
            'data' => $allOrders
        ]);

        return $response;
    }

}