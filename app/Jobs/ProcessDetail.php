<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessDetail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Detail
     */
    private Detail $detail;

    /**
     * Create a new job instance.
     *
     * @param Detail $detail
     */
    public function __construct(Detail $detail)
    {
        $this->detail = $detail;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        Log::info(
            "Processing detail for " . $this->detail->getAuthority()
                                                    ->getName() . "({$this->detail->getDetailUrl()->getUrl()})"
        );
    }
}
