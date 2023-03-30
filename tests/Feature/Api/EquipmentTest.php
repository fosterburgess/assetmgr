<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Equipment;

use App\Models\Location;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentTest extends TestCase
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
    public function it_gets_equipment_list(): void
    {
        $allEquipment = Equipment::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.equipment.index'));

        $response->assertOk()->assertSee($allEquipment[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_equipment(): void
    {
        $data = Equipment::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.equipment.store'), $data);

        unset($data['location_id']);

        $this->assertDatabaseHas('equipment', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_equipment(): void
    {
        $equipment = Equipment::factory()->create();

        $location = Location::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'serial_number' => $this->faker->text(255),
            'purchase_date' => $this->faker->date,
            'metadata' => [],
            'notes' => $this->faker->text,
            'location_id' => $location->id,
        ];

        $response = $this->putJson(
            route('api.equipment.update', $equipment),
            $data
        );

        unset($data['location_id']);

        $data['id'] = $equipment->id;

        $this->assertDatabaseHas('equipment', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_equipment(): void
    {
        $equipment = Equipment::factory()->create();

        $response = $this->deleteJson(
            route('api.equipment.destroy', $equipment)
        );

        $this->assertSoftDeleted($equipment);

        $response->assertNoContent();
    }
}
