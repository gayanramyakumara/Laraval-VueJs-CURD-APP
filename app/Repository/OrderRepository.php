<?php

namespace App\Repository;

use App\Contracts\OrderRepositoryInterface;
use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function create($dataArr)
    {
        # DATABASE SAVING
        return  Order::create($dataArr);

    }

}