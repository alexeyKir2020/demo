<?php

namespace Database\Factories;

use App\Models\Organisation;
use App\Models\Meta\City;
use App\Models\Meta\OrganisationType;
use App\Models\Meta\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class OrganisationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organisation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->company,
            'link' => $this->faker->url,
            'type_id' => OrganisationType::all()->random()->id,
            'city_id' => City::all()->random()->id,
            'reg_number' => $this->faker->numberBetween(100000000, 999999999),
            'email' => $this->faker->unique()->safeEmail,
            'avatar' => 'https://picsum.photos/640/360',
            'contact_person' => $this->faker->firstName.' '.$this->faker->lastName,
            'phone' => $this->faker->unique()->phoneNumber,
            'addition_phone' => $this->faker->phoneNumber,
            'addition_email' => $this->faker->safeEmail,
            'status' => ($this->faker->randomElement(Status::STATUSES))['id'],
            'previous_status' => ($this->faker->randomElement(Status::STATUSES))['id'],
        ];
    }
}
