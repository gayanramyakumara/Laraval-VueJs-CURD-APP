<?php

namespace App\Jobs;

use App\Mail\OrderDetailsMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
 
 

class QueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $emailDetails;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emailDetails)
    {
        
        $this->emailDetails = $emailDetails;

 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
        Mail::to($this->emailDetails['email'])->send(new OrderDetailsMail($this->emailDetails));
    }
}
