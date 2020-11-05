<?php


namespace SimpleRest\Controller;


use SimpleRest\Service\Goods;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class GoodsController
{

    private $goodsService;

    public function __construct(Goods $goodsService)
    {
        $this->goodsService = $goodsService;
    }

    public function generateAction(Request $request)
    {
        $this->goodsService->generateGoods();

        $response = new JsonResponse([
            'data' => [
                'status' => 'success'
            ]
        ]);

        return $response;
    }

    public function allAction(Request $request)
    {
        $page = $request->get('page');
        $count = $request->get('count');

        $allGoods = $this->goodsService->getAllGoods($page, $count);

        $response = new JsonResponse([
            'data' => $allGoods
        ]);

        return $response;
    }

}