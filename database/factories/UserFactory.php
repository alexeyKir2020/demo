<?php

namespace Database\Factories;

use App\Models\Meta\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    public function guestRegistration()
    {
        return $this->state(function (array $attributes) {
            return [
                'email' => $this->faker->unique()->safeEmail,
                'password' => 'adminadmin',
                'password_confirmation' => 'adminadmin',
            ];
        });
    }

    public function validUserLoginCredentials() {

        return $this->state(function (array $attributes) {
            return [
                'username' => 'user@user.com',
                'password' => 'useruser',
            ];
        });
    }

    public function validAdminLoginCredentials() {

        return $this->state(function (array $attributes) {
            return [
                'username' => 'admin@admin.com',
                'password' => 'adminadmin',
            ];
        });
    }

    public function creation()
    {
        return $this->state(function (array $attributes) {
            return [
                'password_confirmation' => 'adminadmin',
            ];
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'second_name' => $this->faker->lastName,
            'third_name' => $this->faker->lastName,
            'avatar' => 'https://picsum.photos/640/360',
            'subscribed' => false,//$this->faker->boolean,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'identity_verified_at' => now()->toISOString(),
            'password' => 'adminadmin',
            'status' => ($this->faker->randomElement(Status::STATUSES))['id'],
            'previous_status' => ($this->faker->randomElement(Status::STATUSES))['id'],
            'requested_changes' => json_encode(["email" => $this->faker->unique()->safeEmail, "phone" => $this->faker->unique()->phoneNumber]),
            'remember_token' => Str::random(10),
        ];
    }
}
