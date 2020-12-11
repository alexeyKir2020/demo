<?php

namespace App\Observers;

use App\Models\User;
use App\Jobs\SendTelegramNotification;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;
use App\Notifications\TelegramNotification;


class UserObserver
{
    public function sendEmail(Mailable $mail)
    {
        Mail::cc(config('mail.notification_emails'))
            ->queue($mail);
    }

    /**
     * Handle the user "created" user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */

    public function created(User $user)
    {

        $heading = Lang::get("user.events.created");
        Log::info('Telegram notification dispatched...', [$user->id]);

        $this->sendEmail(new EmailNotification($user, 'moderator.'. strtolower(User::ENTITY) .'-created', $heading));
        SendTelegramNotification::dispatch($user, new TelegramNotification('notifications.telegram.'. strtolower(User::ENTITY) .'-notification', $heading, true, false))->onQueue('telegram');

    }

    /**
     * Handle the user "updated" user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {

            $heading = Lang::get("user.events.updated");

            $this->sendEmail(new EmailNotification($user, 'moderator.'. $this->item_type .'-updated', $heading));
            SendTelegramNotification::dispatch($user, new TelegramNotification('notifications.telegram.'. $this->item_type .'-notification', $heading, true, false));

    }



    /**
     * Handle the user "deleted" user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {

        $heading = Lang::get("user.events.deleted");

        $this->sendEmail(new EmailNotification($user, 'moderator.'. $this->item_type .'-updated', $heading));
        SendTelegramNotification::dispatch($user, new TelegramNotification('notifications.telegram.'. $this->item_type .'-notification', $heading, true, false));

    }

    /**
     * Handle the user "restored" user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {

        $heading = Lang::get("user.events.restored");

        $this->sendEmail(new EmailNotification($user, 'moderator.'. $this->item_type .'-updated', $heading));
        SendTelegramNotification::dispatch($user, new TelegramNotification('notifications.telegram.'. $this->item_type .'-notification', $heading, true, false));

    }

    /**
     * Handle the user "force deleted" user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {

        $heading = Lang::get("user.events.forceDeleted");

        $this->sendEmail(new EmailNotification($user, 'moderator.'. $this->item_type .'-updated', $heading));
        SendTelegramNotification::dispatch($user, new TelegramNotification('notifications.telegram.'. $this->item_type .'-notification', $heading, true, false));

    }
}
