<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GetUsersTest extends TestCase
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
    public function test_get_user_by_unauthorized_user_test()
    {
        $userId = User::all()->random()->id;

        $response = $this
            ->json(
                'GET',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
            );

        $response->assertUnauthorized();
    }

    /** @test */
    public function test_get_user_by_authorized_user_test()
    {
        $userId = User::query()
            ->where('id', '!=', $this->user->id)
            ->get()
            ->random()
            ->id;

        $response = $this
            ->actingAs($this->user)
            ->json(
                'GET',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
            );

        $response->assertForbidden();
    }

    /** @test */
    public function test_get_user_by_owner_test()
    {
        $response = $this
            ->actingAs($this->user)
            ->json(
                'GET',
                self::API_PATH.'/'.self::ENTITY.'s/'.$this->user->id,
            );

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonPath('data.id', $this->user->id);
    }

    /** @test */
    public function test_get_user_by_moderator_test()
    {
        $userId = User::query()
            ->where(
                'id',
                '!=',
                $this->moderator->id
            )
            ->get()
            ->random()
            ->id;

        $response = $this
            ->actingAs($this->moderator)
            ->json(
                'GET',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
            );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonPath('data.id', $userId);
    }

    /** @test */
    public function test_get_user_by_admin_test()
    {
        $userId = User::query()
            ->where('id', '!=', $this->admin->id)
            ->get()
            ->random()
            ->id;

        $response = $this
            ->actingAs($this->admin)
            ->json(
                'GET',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
            );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonPath('data.id', $userId);
    }

    /** @test */
    public function test_get_missing_user_by_admin_test()
    {
        $userId = "missing";

        $response = $this
            ->actingAs($this->admin)
            ->json(
                'GET',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId,
            );

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function test_get_user_with_relations_by_admin_test()
    {
        $userId = User::query()
            ->where('id', '!=', $this->admin->id)
            ->get()
            ->random()
            ->id;

        $response = $this
            ->actingAs($this->admin)
            ->json(
                'GET',
                self::API_PATH.'/'.self::ENTITY.'s/'.$userId.'?relations=true',
            );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonPath('data.id', $userId);
        $response->assertJsonStructure(
            [
                "data" => [],
                "relations" => []
            ],
            $response->getContent()
        );
    }
}
