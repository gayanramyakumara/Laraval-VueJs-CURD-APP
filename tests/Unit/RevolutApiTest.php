<?php

namespace Tests\Unit;

use Tests\TestCase;

class RevolutApiTest extends TestCase
{
    public function test_revoult_api_failure()
    {
        
        $response = $this->post(route('order-details.store'), [
            
            'email' => 'gayanramyakumara@gmail.com',
            'amount' => 200,
            'currency' => "AUD"
        ]);
        $response->assertStatus($response->status(), 422);
    }

}
