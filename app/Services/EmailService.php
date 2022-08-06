<?php
namespace App\Services;

use App\Contracts\EmailInterface;
use Exception;
use stdClass;

class EmailService implements EmailInterface
{

    public function send($details){
        
        $res = new stdClass();
        $res->status = false;

        try{            
            dispatch(new \App\Jobs\QueueJob($details));
            $res->status = true;

        }catch(Exception $e){
            $res->error = $e->getMessage();
        }

        return $res;
    }

}
