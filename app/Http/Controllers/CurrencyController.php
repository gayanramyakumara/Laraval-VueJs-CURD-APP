<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils;
use Dflydev\DotAccessData\Util;

class CurrencyController extends Controller
{
    
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['currency_data' => Utils::CURRENCY_LIST], Utils::ERROR_CODE_SUCCESS);
    }

}
