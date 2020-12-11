<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateOrganisationsTest extends TestCase
{

    protected const API_PATH = "/api/v1";
    protected const ENTITY = "user";
    protected const TABLE = "users";

    public $user;
    public $moderator;
    public $admin;

    public function setUp() : void
    {
        parent::setUp();

        $this->user =
            User::query()
                ->role(Role::USER)
                ->first();

        $this->moderator =
            User::query()
                ->role(Role::MODERATOR)
                ->first();

        $this->admin =
            User::query()
                ->role(Role::ADMIN)
                ->first();
    }

    /** @test */
    public function test_create_user_by_unauthorized_user_test()
    {

        $user = User::factory()->creation()->raw();

        $response = $this
            ->json(
                'POST',
                self::API_PATH.'/'.self::ENTITY.'s',
                $user,
            );

        $response->assertUnauthorized();
        $this->assertDatabaseMissing(self::TABLE, ['email' => $user['email']]);
    }

    /** @test */
    public function test_create_user_by_authorized_user_test()
    {
        $user = User::factory()->creation()->raw();

        $response = $this
            ->actingAs($this->user)
            ->json(
                'POST',
                self::API_PATH.'/'.self::ENTITY.'s',
                $user,
            );

        $response->assertForbidden();

        $this->assertDatabaseMissing(self::TABLE, ['email' => $user['email']]);
    }

    /** @test */
    public function test_create_user_by_moderator_test()
    {
        $user = User::factory()->creation()->raw();

        $response = $this
            ->actingAs($this->moderator)
            ->json(
                'POST',
                self::API_PATH.'/'.self::ENTITY.'s',
                $user,
            );

        $response->assertStatus(Response::HTTP_CREATED);

        $result = json_decode($response->getContent(), true);
        $this->assertDatabaseHas(self::TABLE, ['id' => $result['id']]);
    }

    /** @test */
    public function test_create_user_by_admin_test()
    {
        $user = User::factory()->creation()->raw();

        $response = $this
            ->actingAs($this->admin)
            ->json(
                'POST',
                self::API_PATH.'/'.self::ENTITY.'s',
                $user,
            );

        $response->assertStatus(Response::HTTP_CREATED);

        $result = json_decode($response->getContent(), true);
        $this->assertDatabaseHas(self::TABLE, ['id' => $result['id']]);
    }

    /** @test */
    public function test_create_invalid_user_by_admin_test()
    {
        $user = [];

        $response = $this
            ->actingAs($this->admin)
            ->json(
                'POST',
                self::API_PATH.'/'.self::ENTITY.'s',
                $user,
            );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
