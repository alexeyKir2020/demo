<?php

namespace Tests\Feature;

use App\Jobs\SendTelegramNotification;
use App\Mail\EmailVerification;
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

class UsersLoginTest extends TestCase
{
    const ENDPOINT = '/login';

    public function setUp() : void
    {
        parent::setUp();
    }

    /** @test */
    public function test_valid_user_credentials_login()
    {
        $user = User::factory()->validUserLoginCredentials()->raw();

        $response = $this
            ->json(
                'POST',
                self::API_PATH.self::ENDPOINT,
                $user,
            );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['access_token']);
    }

    /** @test */
    public function test_invalid_credentials_login()
    {
        $user = [];

        $response = $this
            ->json(
                'POST',
                self::API_PATH.self::ENDPOINT,
                $user,
            );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function test_missing_user_credentials_login()
    {
        $user = [
            'username' => 'missing@email.com',
            'password' => 'missingmissing',
        ];

        $response = $this
            ->json(
                'POST',
                self::API_PATH.self::ENDPOINT,
                $user,
            );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function test_banned_user_login()
    {
        $user = [
            'username' => 'banned@banned.com',
            'password' => 'bannedbanned',
        ];

        $response = $this
            ->json(
                'POST',
                self::API_PATH.self::ENDPOINT,
                $user,
            );

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function test_login_user_redirect()
    {

        $user = User::factory()->validUserLoginCredentials()->raw();

        $response = $this
            ->post(
                self::API_PATH.self::ENDPOINT,
                $user,
            );

        $response->assertRedirect("/account");
    }

    /** @test */
    public function test_login_admin_redirect()
    {
        $user = User::factory()->validAdminLoginCredentials()->raw();

        $response = $this
            ->post(
                self::API_PATH.self::ENDPOINT,
                $user,
            );

        $response->assertRedirect("/admin");
    }
}
