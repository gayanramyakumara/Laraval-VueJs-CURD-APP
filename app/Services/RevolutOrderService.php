<?php
/**
 * Create an orders 
 * 
 * @author Gayan R. <gayanramyakumara@gmail.com>
 * To process the order from a credit or debit card, you create an Order object. You can then retrieve, capture, cancel, refund, or confirm an order using its unique id. 
 * Alternatively, you can use its unique public_id to process a card payment with the Revolut Checkout Widget.
 */

namespace App\Services;

use App\Utils;
use Exception;
use Illuminate\Support\Facades\Http;
use stdClass;

class RevolutOrderService
{
    const API_SUCCESS_STATUS = 201;
    
    public $header;

    public function __construct()
    {
        $this->header = [
            'Authorization' => env('REVOLUT_ORDER_CREATION_API_KEY')
        ];
    }


    public function create(array $requestData)
    {
        $res = new stdClass();
        $res->status = false;
        $res->error = null;

        try{
    
            $requestData = [
                'email'     => $requestData['email'],
                'amount'    => (int)round($requestData['amount']),
                'currency'  => $requestData['currency']
            ];

            $response = Http::withHeaders($this->header)
                        ->post( 
                            env('REVOLUT_ORDER_CREATION_API_URL'), 
                            $requestData
                        );
       
            if($response->failed() === false && $response->status() == self::API_SUCCESS_STATUS){
                $res->status = true;
                $res->data   = json_decode($response->getBody(), true);
            }else{
                $failure_data = json_decode($response->getBody(), true);
                $res->error = Utils::REVOLUT_API_FAILURE." - ".$failure_data['errorId'];
            }

        }catch(Exception $e){
      
            $res->error = $e->getMessage();
        }
 
       

        return $res;
    }
   
}