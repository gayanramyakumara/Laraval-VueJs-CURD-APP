<?php

namespace Tests\Unit;

use Tests\TestCase;

class OrderFormTest extends TestCase
{
    
    public function test_create_order_request()
    {
        $response = $this->post(route('order-details.store'), [
            
            'email' => 'gayanramyakumara@gmail.com',
            'amount' => 200,
            'currency' => "AUD"
        ]);
        $response->assertStatus($response->status(), 200);
    }

    public function test_is_order_email_form_mandatory()
    {
        $response = $this->post(route('order-details.store'), [
            'email' => null,
            'amount' => 347,
            'currency' => "AUD"
        ]);

        $response->assertStatus($response->status(), 422);
    }


    public function test_is_order_amount_form_mandatory()
    {
        $response = $this->post(route('order-details.store'), [
            'email' => 'gayanramyakumara@gmail.com',
            'amount' => null,
            'currency' => "AUD"
        ]);

        $response->assertStatus($response->status(), 422);
    }
        
    public function test_is_order_currency_form_mandatory()
    {
        $response = $this->post(route('order-details.store'), [
            'email' => 'gayanramyakumara@gmail.com',
            'amount' => 356,
            'currency' => null
        ]);

        $response->assertStatus($response->status(), 422);
    }
}
