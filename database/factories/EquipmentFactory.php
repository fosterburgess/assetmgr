<?php

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Equipment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'serial_number' => $this->faker->text(255),
            'purchase_date' => $this->faker->date,
            'metadata' => [],
            'notes' => $this->faker->text,
        ];
    }
}
