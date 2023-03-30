<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Location;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_locations_list(): void
    {
        $locations = Location::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.locations.index'));

        $response->assertOk()->assertSee($locations[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_location(): void
    {
        $data = Location::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.locations.store'), $data);

        unset($data['owner_id']);
        unset($data['team_id']);
        unset($data['country']);
        unset($data['notes']);

        $this->assertDatabaseHas('locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_location(): void
    {
        $location = Location::factory()->create();

        $user = User::factory()->create();

        $data = [
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
            'owner_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.locations.update', $location),
            $data
        );

        unset($data['owner_id']);
        unset($data['team_id']);
        unset($data['country']);
        unset($data['notes']);

        $data['id'] = $location->id;

        $this->assertDatabaseHas('locations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_location(): void
    {
        $location = Location::factory()->create();

        $response = $this->deleteJson(
            route('api.locations.destroy', $location)
        );

        $this->assertSoftDeleted($location);

        $response->assertNoContent();
    }
}
