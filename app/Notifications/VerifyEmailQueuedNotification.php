<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail;

class VerifyEmailQueuedNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->queue = 'mail';
    }
}
