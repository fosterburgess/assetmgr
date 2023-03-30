<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => $this->faker->randomNumber,
            'name' => $this->faker->name(),
            'logo' => $this->faker->word,
            'address1' => $this->faker->address,
            'address2' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'notes' => $this->faker->text,
            'url1' => $this->faker->url,
            'url2' => $this->faker->text(255),
            'url3' => $this->faker->url,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'owner_id' => \App\Models\User::factory(),
        ];
    }
}
