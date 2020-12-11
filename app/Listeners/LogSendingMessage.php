<?php
namespace App\Listeners;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Log;

class LogSendingMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(MessageSending $event)
    {
        Log::info('Sending email message...', $event->data);
    }
}
