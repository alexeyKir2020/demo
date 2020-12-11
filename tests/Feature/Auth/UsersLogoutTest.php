<?php

namespace Tests\Feature;

use App\Jobs\SendTelegramNotification;
use App\Mail\EmailVerification;
use App\Models\Meta\Status;
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

class UsersLogoutTest extends TestCase
{
    const ENDPOINT = '/logout';

    public function setUp() : void
    {
        parent::setUp();
    }

    /** @test */
    public function test_logout_unauthorized()
    {
        $response = $this
            ->json(
                'GET',
                self::API_PATH.self::ENDPOINT
            );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function test_succesfull_logout()
    {
        $user = User::query()
            ->where('status', '!=', Status::SUSPENDED)
            ->get()
            ->random();

        $response = $this
            ->actingAs($user)
            ->get(
                self::ENDPOINT
            );


        $response->assertRedirect("/");
    }

    /** @test */
    public function test_logout_with_token()
    {
        $user = User::query()
            ->where('status', '!=', Status::SUSPENDED)
            ->get()
            ->random();


        $token = $user->createToken('access_token')->plainTextToken;

        $response = $this
            ->json(
                'GET',
                self::API_PATH.self::ENDPOINT,
                [],
                ['Authorization' => "Bearer $token"]
            );

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function test_logout_with_invalid_token()
    {
        $response = $this
            ->json(
                'GET',
                self::API_PATH.self::ENDPOINT,
                ['Authorization' => 'Bearer ']
            );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function test_logout_redirect()
    {

        $admin = User::query()
            ->role(Role::ADMIN)
            ->first();

        $response = $this
            ->actingAs($admin)
            ->get(
                self::ENDPOINT
            );

        $response->assertRedirect("/");
    }
}
