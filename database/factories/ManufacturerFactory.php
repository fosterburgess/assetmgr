<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManufacturerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Manufacturer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'url1' => $this->faker->text(255),
            'url2' => $this->faker->text(255),
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
