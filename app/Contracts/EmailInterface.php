<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface EmailInterface
{
    public function send($dataArr);

}