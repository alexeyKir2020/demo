<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendTelegramNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $item;
    public $notification;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($item, $notification)
    {
        $this->item = $item;
        $this->notification = $notification;

        Log::info('Telegram job created...', []);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Executing job...', []);
        $this->item->notify($this->notification);

        Log::info('Executed job...', []);
    }
}
