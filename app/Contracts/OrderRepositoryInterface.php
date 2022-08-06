<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface OrderRepositoryInterface
{
    public function create($dataArr);

}