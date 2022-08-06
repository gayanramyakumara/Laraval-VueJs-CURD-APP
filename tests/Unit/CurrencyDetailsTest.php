<?php

namespace Tests\Unit;

use Tests\TestCase;

class CurrencyDetailsTest extends TestCase
{

    public function test_currency_request()
    {
        $res = $this->get('api/currency-list');
        $res->assertStatus($res->status(),200);
    }
}
