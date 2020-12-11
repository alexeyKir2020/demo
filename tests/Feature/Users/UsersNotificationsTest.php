<?php

namespace Tests\Feature;

use App\Jobs\SendTelegramNotification;
use App\Models\Role;
use App\Models\User;
use App\Notifications\TelegramNotification;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UsersNotificationsTest extends TestCase
{

    protected const API_PATH = "/api/v1";
    protected const ENTITY = "user";
    protected const TABLE = "users";

    public $actingAdminUser;
    public $actingModeratorUser;
    public $actingUsualUser;

    public function setUp() : void
    {
        parent::setUp();

        $this->actingAdminUser =
            User
                ::factory()
                ->create()
                ->assignRole(Role::all());
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function test_user_created_notification_to_moderator()
    {
        Queue::fake();

        $user = User::factory()->make();

        $response = $this
            ->actingAs($this->actingAdminUser)
            ->json('POST',
                self::API_PATH.'/'.self::ENTITY.'s',
                array_merge($user->getAttributes(), ['password_confirmation' =>  ($user->getAttributes())['password']]), ['Accept' => 'application/json']);

        $response->assertStatus(Response::HTTP_CREATED);

        Queue::assertPushedOn('telegram', SendTelegramNotification::class);
    }
}
