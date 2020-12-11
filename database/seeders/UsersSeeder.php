<?php

namespace Database\Seeders;

use App\Models\Meta\HardSkill;
use App\Models\Meta\Interest;
use App\Models\Meta\Language;
use App\Models\Meta\SoftSkill;
use App\Models\Organisation;
use App\Models\Role;
use App\Models\Meta\Status;
use App\Models\Resume;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;


class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $organisations = Organisation::all();

        User
            ::factory(5)
            ->create()
            ->each(function ($user) use ($organisations) {
                $user->assignRole(
                    [
                        Role::SUBSCRIBER,
                        Role::USER,
                    ]);
                $user->organisations()->attach(
                    $organisations->random(rand(1, 3))->pluck('id')->toArray(),
                    ['is_owner' => true]
                );
            });

        User
            ::factory(5)
            ->has(Resume::factory()->count(3))
            ->create()
            ->each(function ($user) {
                $user->assignRole(
                    [
                        Role::SUBSCRIBER,
                        Role::USER,
                        Role::MEMBER,
                        Role::AUTHOR,
                    ]
                );
            });

        User
            ::factory(5)
            ->create()
            ->each(function ($user) use ($organisations) {
                $user->assignRole(
                    [
                        Role::SUBSCRIBER,
                        Role::USER,
                        Role::MEMBER,
                        Role::AUTHOR,
                        Role::MODERATOR
                    ]);

                $user->organisations()->attach(
                    $organisations->random(rand(1, 3))->pluck('id')->toArray(),
                    ['is_owner' => true]
                );
            });

        User
            ::factory(5)
            ->has(Resume::factory()->count(3))
            ->create()
            ->each(function ($user) {
                $user->assignRole(
                    [
                        Role::SUBSCRIBER,
                        Role::USER,
                        Role::MEMBER,
                    ]);
            });

        User
            ::factory(5)
            ->has(Resume::factory()->count(3))
            ->create()
            ->each(function ($user) use ($organisations) {
                $user->assignRole(
                    [
                        Role::SUBSCRIBER,
                        Role::USER,
                        Role::MEMBER,
                        Role::AUTHOR,
                        Role::MODERATOR
                    ]);
                $user->organisations()->attach(
                    $organisations->random(rand(1, 3))->pluck('id')->toArray(),
                    ['is_owner' => true]
                );
            });

        User
            ::factory()
            ->create([
                'email' => 'unverifieduser@user.com',
                'password' => Hash::make('useruser'),
            ])->assignRole('guest', 'user');
        User
            ::factory()
            ->create([
                'email' => 'user@user.com',
                'identity_verified_at' => '2019-09-10 00:00:00',
                'password' => Hash::make('useruser'),
                'status' => 1,
            ])->assignRole('guest', 'user');

        User
            ::factory()
            ->create([
                'email' => 'banned@banned.com',
                'identity_verified_at' => '2019-09-10 00:00:00',
                'password' => Hash::make('bannedbanned'),
                'status' => Status::SUSPENDED,
            ])->assignRole('guest', 'user');

        User
            ::factory()
            ->create([
                'email' => 'author@author.com',
                'identity_verified_at' => '2019-09-10 00:00:00',
                'password' => Hash::make('authorauthor'),
                'status' => 1,
            ])->assignRole('guest', 'user', 'author');

        User
            ::factory()
            ->create([
                'email' => 'moderator@moderator.com',
                'identity_verified_at' => '2019-09-10 00:00:00',
                'password' => Hash::make('moderatormoderator'),
                'status' => 1,
            ])->assignRole('guest', 'user', 'author', 'moderator');

        User
            ::factory()
            ->create([
                'email' => 'admin@admin.com',
                'identity_verified_at' => '2019-09-10 00:00:00',
                'password' => Hash::make('adminadmin'),
                'status' => 1,
            ])->assignRole(Role::all());

        User
            ::factory()
            ->has(Organisation::factory()->count(3))
            ->create([
                'email' => 'admin2@admin.com',
                'identity_verified_at' => '2019-09-10 00:00:00',
                'password' => Hash::make('adminadmin'),
                'status' => 1,
            ])->assignRole(Role::all());

        User
            ::factory()
            ->has(Organisation::factory()->count(3))
            ->create([
                'email' => 'developer@dev.by',
                'identity_verified_at' => '2019-09-10 00:00:00',
                'password' => Hash::make('Developer69'),
                'status' => 1,
            ])->assignRole(Role::all());

    }
}
