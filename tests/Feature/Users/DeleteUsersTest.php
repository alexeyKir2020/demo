<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DeleteUsersTest extends TestCase
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
    public function test_delete_user_by_unauthorized_user_test()
    {
        $userId = User::all()->random()->id;

        $response = $this
            ->json(
                'DELETE',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
            );

        $response->assertUnauthorized();

        $this->assertDatabaseHas(self::TABLE, ['id' => $userId]);
    }

    /** @test */
    public function test_delete_user_by_authorized_user_test()
    {
        $userId = User::query()
            ->where('id', '!=', $this->user->id)
            ->get()
            ->random()
            ->id;

        $response = $this
            ->actingAs($this->user)
            ->json(
                'DELETE',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
            );

        $response->assertForbidden();
        $this->assertDatabaseHas(self::TABLE, ['id' => $userId]);
    }

    /** @test */
    public function test_delete_user_by_owner_test()
    {
        $user = $this->user;
        $response = $this
            ->actingAs($user)
            ->json(
                'DELETE',
                self::API_PATH.'/'.self::ENTITY.'s/'.$user->id,
            );

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertSoftDeleted(self::TABLE, ['id' => $user->id]);
    }

    /** @test */
    public function test_delete_user_by_moderator_test()
    {
        $userId = User::query()
            ->where('id', '!=', $this->moderator->id)
            ->get()
            ->random()
            ->id;

        $response = $this
            ->actingAs($this->moderator)
            ->json(
                'DELETE',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
            );

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertSoftDeleted(self::TABLE, ['id' => $userId]);

    }

    /** @test */
    public function test_delete_user_by_admin_test()
    {
        $userId = User::query()
            ->where('id', '!=', $this->admin->id)
            ->get()
            ->random()
            ->id;

        $response = $this
            ->actingAs($this->admin)
            ->json(
                'DELETE',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
            );

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertSoftDeleted(self::TABLE, ['id' => $userId]);
    }

    /** @test */
    public function test_delete_missing_user_by_admin_test()
    {
        $userId = 'missing';

        $response = $this
            ->actingAs($this->admin)
            ->json(
                'DELETE',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
            );

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
