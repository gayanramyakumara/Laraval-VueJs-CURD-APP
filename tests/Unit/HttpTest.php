<?php

namespace Tests\Unit;

use Tests\TestCase;

class HttpTest extends TestCase
{
 
    public function test_order_form_request()
    {
        $res = $this->get('/order-details');
        $res->assertStatus(200);
    }
}
