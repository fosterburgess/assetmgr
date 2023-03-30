<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Location;
use App\Models\Equipment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationAllEquipmentTest extends TestCase
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
    public function it_gets_location_all_equipment(): void
    {
        $location = Location::factory()->create();
        $allEquipment = Equipment::factory()
            ->count(2)
            ->create([
                'location_id' => $location->id,
            ]);

        $response = $this->getJson(
            route('api.locations.all-equipment.index', $location)
        );

        $response->assertOk()->assertSee($allEquipment[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_location_all_equipment(): void
    {
        $location = Location::factory()->create();
        $data = Equipment::factory()
            ->make([
                'location_id' => $location->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.locations.all-equipment.store', $location),
            $data
        );

        unset($data['location_id']);

        $this->assertDatabaseHas('equipment', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $equipment = Equipment::latest('id')->first();

        $this->assertEquals($location->id, $equipment->location_id);
    }
}
