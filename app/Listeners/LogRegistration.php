<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Log;

class LogRegistration
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

    public function handle(Registered $event)
    {
        Log::info('User register', ['instance' => ($event->user instanceof MustVerifyEmail), 'verifiedEmail' => ($event->user->hasVerifiedEmail())]);
    }
}
