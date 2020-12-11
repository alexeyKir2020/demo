<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Mockery;

class IndexUsersTest extends TestCase
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
    public function test_index_users_by_unauthorized_user_test()
    {
        $response = $this
            ->json(
                'GET',
                self::API_PATH.'/'.self::ENTITY.'s',
            );

        $response->assertUnauthorized();
    }

    /** @test */
    public function test_index_users_by_authorized_user_test()
    {
        $response = $this
            ->actingAs($this->user)
            ->json(
                'GET',
                self::API_PATH.'/'.self::ENTITY.'s',
                [] ,
                ['Accept' => 'application/json']
            );

        $response->assertForbidden();
    }

    /** @test */
    public function test_index_users_by_moderator_test()
    {
        $response = $this
            ->actingAs($this->moderator)
            ->json(
                'GET',
                self::API_PATH.'/'.self::ENTITY.'s',
            );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(User::all()->count(), 'data');
    }

    /** @test */
    public function test_index_users_by_admin_test()
    {
        $response = $this
            ->actingAs($this->admin)
            ->json(
                'GET',
                self::API_PATH.'/'.self::ENTITY.'s',
            );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(User::all()->count(), 'data');
    }

    /** @test */
    public function test_index_users_with_relations_by_admin_test()
    {
        $response = $this
            ->actingAs($this->admin)
            ->json(
                'GET',
                self::API_PATH.'/'.self::ENTITY.'s?relations=true',
            );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(User::all()->count(), 'data');
        $response->assertJsonStructure(
            [
                "data" => [],
                "relations" => []
            ],
            $response->getContent()
        );
    }


}
