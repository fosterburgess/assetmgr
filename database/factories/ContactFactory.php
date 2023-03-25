<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->word,
            'name' => $this->faker->name(),
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'mobile' => $this->faker->phoneNumber,
            'notes' => $this->faker->text,
            'avatar' => $this->faker->word,
        ];
    }
}
