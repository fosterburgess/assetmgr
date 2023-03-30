<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Equipment;

use App\Models\Location;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    protected function castToJson($json)
    {
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        } elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \Exception(
                'A valid JSON string was not provided for casting.'
            );
        }

        return \DB::raw("CAST('{$json}' AS JSON)");
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_equipment(): void
    {
        $allEquipment = Equipment::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('equipment.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.equipment.index')
            ->assertViewHas('allEquipment');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_equipment(): void
    {
        $response = $this->get(route('equipment.create'));

        $response->assertOk()->assertViewIs('app.equipment.create');
    }

    /**
     * @test
     */
    public function it_stores_the_equipment(): void
    {
        $data = Equipment::factory()
            ->make()
            ->toArray();

        $data['metadata'] = json_encode($data['metadata']);

        $response = $this->post(route('equipment.store'), $data);

        unset($data['location_id']);

        $data['metadata'] = $this->castToJson($data['metadata']);

        $this->assertDatabaseHas('equipment', $data);

        $equipment = Equipment::latest('id')->first();

        $response->assertRedirect(route('equipment.edit', $equipment));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_equipment(): void
    {
        $equipment = Equipment::factory()->create();

        $response = $this->get(route('equipment.show', $equipment));

        $response
            ->assertOk()
            ->assertViewIs('app.equipment.show')
            ->assertViewHas('equipment');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_equipment(): void
    {
        $equipment = Equipment::factory()->create();

        $response = $this->get(route('equipment.edit', $equipment));

        $response
            ->assertOk()
            ->assertViewIs('app.equipment.edit')
            ->assertViewHas('equipment');
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

        $data['metadata'] = json_encode($data['metadata']);

        $response = $this->put(
            route('equipment.update', $equipment),
            $data
        );

        unset($data['location_id']);

        $data['id'] = $equipment->id;

        $data['metadata'] = $this->castToJson($data['metadata']);

        $this->assertDatabaseHas('equipment', $data);

        $response->assertRedirect(route('equipment.edit', $equipment));
    }

    /**
     * @test
     */
    public function it_deletes_the_equipment(): void
    {
        $equipment = Equipment::factory()->create();

        $response = $this->delete(route('equipment.destroy', $equipment));

        $response->assertRedirect(route('equipment.index'));

        $this->assertSoftDeleted($equipment);
    }
}
