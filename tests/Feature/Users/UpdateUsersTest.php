<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateUsersTest extends TestCase
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
    public function test_update_user_by_unauthorized_user_test()
    {
        $userId = User::all()->random()->id;
        $user = User::factory()->creation()->raw();

        $response = $this
            ->json(
                'PATCH',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
                $user,
            );

        $response->assertUnauthorized();

        $this->assertDatabaseMissing(self::TABLE, ['email' => $user['email'], 'id' => $userId]);
    }

    /** @test */
    public function test_update_user_by_authorized_user_test()
    {
        $userId = User::query()
            ->where('id', '!=', $this->user->id)
            ->get()
            ->random()
            ->id;

        $user = User::factory()->creation()->raw();

        $response = $this
            ->actingAs($this->user)
            ->json(
                'PATCH',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
                $user,
            );

        $response->assertForbidden();

        $this->assertDatabaseMissing(self::TABLE, ['email' => $user['email'], 'id' => $userId]);
    }

    /** @test */
    public function test_update_user_by_owner_test()
    {
        $user = User::factory()->creation()->raw();

        $response = $this
            ->actingAs($this->user)
            ->json(
                'PATCH',
                self::API_PATH.'/'.self::ENTITY.'s/'.$this->user->id,
                $user,
            );

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseHas(self::TABLE, ['id' => $this->user->id]);
    }

    /** @test */
    public function test_update_user_by_moderator_test()
    {
        $userId = User::query()->where('id', '!=', $this->moderator->id)->get()->random()->id;
        $user = User::factory()->creation()->raw();

        $response = $this
            ->actingAs($this->moderator)
            ->json(
                'PATCH',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
                $user,
                            );

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseHas(self::TABLE, ['email' => $user['email'], 'id' => $userId]);
    }

    /** @test */
    public function test_update_user_by_admin_test()
    {
        $userId = User::query()
            ->where('id', '!=', $this->admin->id)
            ->get()
            ->random()
            ->id;

        $user = User::factory()->creation()->raw();

        $response = $this
            ->actingAs($this->admin)
            ->json(
                'PATCH',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
                $user,
            );

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseHas(self::TABLE, ['email' => $user['email'], 'id' => $userId]);
    }

    /** @test */
    public function test_update_user_with_invalid_data_by_admin_test()
    {
        $userId = User::query()
            ->where('id', '!=', $this->admin->id)
            ->get()
            ->random()
            ->id;

        $user = ['password' => '111'];

        $response = $this
            ->actingAs($this->admin)
            ->json(
                'PATCH',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
                $user,
            );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function test_update_missing_user_by_admin_test()
    {
        $userId = 'missing';

        $user = User::factory()->creation()->raw();

        $response = $this
            ->actingAs($this->admin)
            ->json(
                'PATCH',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
                $user,
            );

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

}
