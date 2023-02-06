<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    //حاول كم مرة
    public $tries = 3 ;
    // تاخير مرتين ثانيتين بين كل وحدة
    public $backoff = 2 ;

    // اقصى عدد من الاكسسيبشن
    public $maxExceptions = 3 ;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        throw new Exception('Exceptio Occurs - Test Job');
        sleep(3);
        info('Test Job Execution');
        //انو كل م تخلص يرجع ينفذها بعد ثانيتين
        $this->release(2);
    }

    public function failed($e){
        Log::error('Test job Execution');
    }
}
