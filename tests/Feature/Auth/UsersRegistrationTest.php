<?php

namespace Tests\Feature;

use App\Jobs\SendTelegramNotification;
use App\Mail\EmailVerification;
use App\Models\Role;
use App\Models\User;
use App\Notifications\TelegramNotification;
use Database\Factories\UserFactory;
use App\Notifications\VerifyEmailQueuedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UsersRegistrationTest extends TestCase
{

    protected const API_PATH = "/api/v1";

    public function setUp() : void
    {
        parent::setUp();
    }

    /** @test */
    public function test_user_registration()
    {
        Notification::fake();

        $user = User::factory()->guestRegistration()->raw();

        $response = $this
            ->json('POST',
                self::API_PATH.'/register',
                $user,
                ['Accept' => 'application/json']
            );

        $decoded = json_decode($response->getContent());

        $user = User::query()
            ->where('id', $decoded->data->id)
            ->get();

        Notification::assertSentTo($user, VerifyEmailQueuedNotification::class);

        $response->assertStatus(Response::HTTP_CREATED);

    }
}
